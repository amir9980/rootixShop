<?php

namespace App\Http\Controllers;

use App\Models\WalletPayment;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dates are in jalali:
        $request['from_date'] = convert($request->from_date);
        $request['to_date'] = convert($request->to_date);

        $request->validate([
            'role'=>'nullable|string|in:admin,user',
            'email'=>'nullable|email',
            'username'=>'nullable|string|max:50',
            'from_date' => 'nullable|regex:/....\/..\/../',
            'to_date' => 'nullable|regex:/....\/..\/../',
        ]);

        $users = user::query();

        if ($request->has('username') && !empty($request->username)) {
            $users = $users->where('username', 'LIKE', '%' . $request->username . '%');
        }

        if ($request->has('email') && !empty($request->email)) {
            $users = $users->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->has('role') && !empty($request->role)) {
            if ($request->role=='admin'){
                $users = $users->where('is_admin', '=', 1);

            }elseif($request->role=='user')
            $users = $users->where('is_admin', '=', 0);
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $users = $users->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $request->from_date . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $users = $users->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $request->to_date . ' 23:59:59'));
        }

        $users = $users->paginate(15)->withQueryString();;

        $iteration = ($users->currentPage() - 1) * $users->perPage();
        return view('admin.users.index', ['users' => $users, 'iteration' => $iteration]);
    }

    public function edit(Request $request,user $user){

        $u = user::find($user->id);
        return view('admin.users.editUsers', ['user' => $u]);
    }

    public function update(Request $request,user $user){

        //        value is in number format like 10,000 so:
        $request['wallet'] = str_replace(',','',$request->wallet);

    $request->validate([
        'username'=>'required|string',
        'role'=>'required|string|in:admin,user',
        'status'=>'required|string|in:Active,Inactive',
        'wallet'=>'nullable|numeric',
        'new_password'=>'nullable|confirmed',
        'img'=>'nullable|mimes:jpg,jpeg,png|max:2024'
    ]);

    try{

        $user->username=$request->username;

        if ($request->role == 'admin'){
            $user->is_admin = 1;
        }
        elseif ($request->role == 'user'){
            $user->is_admin = 0;
        }

        $user->status = $request->status;

        if (!empty($request->wallet)){
            WalletPayment::create([
                'user_id'=>$user->id,
                'value'=>$request->wallet
            ]);

            $user->wallet += $request->wallet;
        }

        if (!empty($request->new_password)){
            $user->password = bcrypt($request->new_password);
        }

        $fileName = $user->profile_pic;
        if ($request->has('img') && !empty($request->file('img'))){
            $fileName = $request->file('img')->hashName();
            $request->file('img')->storeAs('images/users', $fileName);
        }

        $user->profile_pic = $fileName;

        $user->save();

        return redirect()->back()->with('message','کاربر با موفقیت ویرایش شد!');



    }catch(Exception $e){
        return redirect()->back()->withErrors($e);
    }



    }

    public function showProfile(Request $request){


        return view('users.profile');
    }

    public function storeProfile(Request $request){

        $request->validate([
            'username'=>'required|string|max:255',
            'img'=>'nullable|mimes:jpg,png,jpeg|max:2048'
        ]);
        try{
            $user = user::find($request->user()->id);
            $fileName = $user->profile_pic;
            if ($request->has('img') && !empty($request->file('img'))) {
                $fileName = $request->file('img')->hashName();
                $request->file('img')->storeAs('images/users', $fileName);
            }

            $user->username = $request->username;
            $user->profile_pic = $fileName;
            $user->save();

            return redirect()->back()->with('message','پروفایل با موفقیت ویرایش شد!');

        }catch (\Exception $e){
            return redirect()->back()->withErrors($e);
        }

    }

    public function charge(Request $request){
        return view('users.charge');
    }


    public function bookmarks(Request $request){
        $products = $request->user()->bookmarks;
        return view('users.bookmarks',compact('products'));
    }

}
