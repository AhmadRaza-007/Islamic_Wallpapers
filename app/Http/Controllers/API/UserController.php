<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\restcode;
use App\Models\Category;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserId;
use App\Models\WallpaperDislike;
use App\Models\WallpaperFavourite;
use App\Models\WallpaperLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function user()
    {
        if (Auth::check()) {
            return response(Auth::user(), 201);
        } else {
            return response('Token is Invalid', 401);
        }
    }
    public function postLogin(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_type' => 2])) {
                $user = User::where('email', $request->email)->first();
                $token = $user->createToken($request->email)->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'token' => $token,
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The provided credentials are incorrect.',

                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . ' ' . $exception->getLine(),

            ]);
        }
    }

    public function userId($userId)
    {
        try {
            UserId::create([
                'user_uid' => $userId
            ]);

            return response()->json([
                'status' => 'success',
                'uid' => $userId,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function signup(Request $request)
    {
        $inputs = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        if (!($inputs)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Make sure to filled all fields Correctly',

            ]);
        } else {
            try {
                $user = User::create([
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request->password),
                ]);
                $token = $user->createToken('signup')->plainTextToken;
                return  response()->json([
                    'status' => 'success',
                    'token' => $token,
                    'user' => $user,
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage() . ' ' . $exception->getLine(),

                ]);
            }
        }
    }

    public function forgetpassword(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $user = User::whereEmail($request->email)->whereUserType(2)->first();
        if ($user) {
            $code = rand(100000, 999999);
            User::whereId($user->id)->update(['reset_code' => $code]);
            Mail::to($user->email)->send(new restcode($code));
            return  response()->json([
                'status' => 'success',
                'message' => 'Code has been sent',
            ]);
        } else {
            return  response()->json([
                'status' => 'error',
                'message' => 'Provide Correct Email',
            ]);

        }
    }



    public function changePassword(Request $request)
    {
        $inputs = $request->validate([
            'reset_code' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        try {
            if (!($inputs)) {
                return  response()->json([
                    'status' => 'error',
                    'message' => 'Make sure to filled all fields Correctly',

                ]);
            } else {
                $user = User::where('reset_code', $request->reset_code)->first();
                if ($user) {
                    User::whereResetCode($request['reset_code'])->update(['password' => \Hash::make($request['password']), 'reset_code' => null]);
                    $user->tokens()->delete();
                    $token = $user->createToken('passwordUpdated')->plainTextToken;
                    return  response()->json([
                        'status' => 'success',
                        'token' => $token,
                        'user' => $user,
                    ]);
                } else {
                    return  response()->json([
                        'status' => 'error',
                        'message' => 'Invalid Reset Code',

                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . ' ' . $exception->getLine(),

            ]);
        }
    }

    public function deleteUser(Request $request)
    {
        $inputs = $request->validate([
            'password' => 'required|min:6',
        ]);
        if ($inputs) {
            $user = auth()->user();
            $user_detail = User::whereId($user->id)->first();
            if ($user_detail && Hash::check($request->password, $user->password)) {
                $favrt_rec = WallpaperFavourite::whereUserId($user->id)->delete();
                $like_rec = WallpaperLike::whereUserId($user->id)->delete();
                $dislike_rec = WallpaperDislike::whereUserId($user->id)->delete();
                $User_del = User::whereId($user->id)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Deleted Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'please enter your correct Password',
                ]);
            }
        } else {
            return  response()->json([
                'status' => 'error',
                'message' => "invalid param's Password",
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return  response()->json([
            'status' => 'success',
            'message' => 'tokens deleted',

        ]);
    }
}
