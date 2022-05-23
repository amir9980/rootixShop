<?php

namespace App\Http\Controllers;

use App\Models\WalletPayment;
use App\Models\user;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

//        $validated = Validator::make($request->all(), [
//            'title' => 'nullable|max:255',
//            'from_price' => 'nullable|numeric',
//            'to_price' => 'nullable|numeric',
//            'from_date' => 'nullable',
//            'to_date' => 'nullable',
//            'status' => 'nullable|digits_between:1,3',
//
//        ]);
//        if ($validated->fails()) {
//            return redirect()->back()->withInput()->withErrors($validated);
//        }

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
            $users = $users->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->from_date) . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $users = $users->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->to_date) . ' 23:59:59'));
        }

        $users = $users->paginate(15)->withQueryString();;

        $iteration = ($users->currentPage() - 1) * $users->perPage();
        $cart = \Illuminate\Support\Facades\Auth::user()->cart;
        return view('admin.users.index', ['users' => $users, 'cart' => $cart, 'iteration' => $iteration]);
    }

    public function edit(Request $request,user $user){

        $u = user::find($user->id);
        return view('admin.users.editUsers', ['user' => $u]);
    }

    public function update(Request $request,$u){

        //        value is in number format like 10,000 so:
        $request['wallet'] = str_replace(',','',$request->wallet);

    $request->validate([
        'username'=>'required|string',
        'role'=>'required',
        'wallet'=>'nullable|numeric',
        'new_password'=>'nullable|confirmed',
        'img'=>'nullable|mimes:jpg,jpeg,png|max:2024'
    ]);

    try{

        $user = user::find($u);

        $user->username=$request->username;

        if ($request->role == 'admin'){
            $user->is_admin = 1;
        }
        elseif ($request->role == 'user'){
            $user->is_admin = 0;
        }

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


        return view('users.profile',['cart'=>$request->user()->cart]);
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
        return view('users.charge',['cart'=>$request->user()->cart]);
    }

}
