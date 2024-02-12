<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Wallpaper;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function dashboard()
    {
        $userCount = User::whereUserType(2)->count();
        $categoryCount = Category::count();
        $wallpapersCount = Wallpaper::count();
        $categories = Category::get();
        return view('dashboard', compact('categoryCount', 'userCount', 'wallpapersCount', 'categories'));
    }
    public function updateDeviceToken(Request $request)
    {
        UserDevice::create(['device_token' => $request->token, 'user_id' => Auth::user()->id, 'logged_in' => 1]);
        return response()->json(['token saved successfully.']);
    }
    public function postLogin(Request $request)
    {
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);

        // User::create([
        //     'first_name' => 'admin',
        //     'last_name' => 'admin',
        //     'user_type' => '1',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('125@0ab%'),
        // ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_type' => 1], $request->remember)) {
            //            if (!empty($chek_device)) {
            //                $chek_device->update([
            //                    'logged_in' => 1
            //                ]);
            //            }else {
            //                $user_devices = UserDevice::create([
            //                    'user_id' => Auth::user()->id,
            //                    'device_token' => $request->device_token,
            //                    'device_type' => $request->device_type,
            //                    'device_name' => $request->device_name,
            //                    'logged_in' => 1
            //
            //                ]);
            //            }
            Session::flash('success', 'Login Successfully');
            return redirect('dashboard');
        } else {
            Session::flash('error', 'User Credentials are Wrong!');
            return redirect('login');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        Auth::logout();
        return redirect()->route('login');
    }
}
