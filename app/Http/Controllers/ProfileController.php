<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\user;

class ProfileController extends Controller
{
    public function show(){
        return view('users.profile');
    }

    public function update(Request $request){
        $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'state'=>'required|string|max:255',
            'city'=>'required|string|max:255',
            'address'=>'required|string',
//            'username'=>'required|string|max:255',
//            'img'=>'nullable|mimes:jpg,png,jpeg|max:2048'
        ]);
        try{

            Profile::updateOrCreate([
                'user_id'=>$request->user()->id
            ],[
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'state'=>$request->state,
                'city'=>$request->city,
                'address'=>$request->address,
            ]);
//            $user = user::find($request->user()->id);
//            $fileName = $user->profile_pic;
//            if ($request->has('img') && !empty($request->file('img'))) {
//
//                $fileName = $request->file('img')->hashName();
//                $request->file('img')->storeAs('images/users', $fileName);
//            }
//
//            $user->username = $request->username;
//            $user->profile_pic = $fileName;
//            $user->save();



            return redirect()->back()->with('message','پروفایل با موفقیت ویرایش شد!');

        }catch (\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }
}
