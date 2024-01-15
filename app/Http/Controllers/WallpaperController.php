<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\Wallpaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WallpaperController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $wallpapers = Wallpaper::with('category')->withCount('likes', 'dislikes')->orderBy('id', 'desc')->get();
        return view('categories.wallpaper', compact('categories', 'wallpapers'));
    }

    public function wall(Request $request, $id)
    {
        // return $id;
        $categories = Category::get();
        $wallpapers = Wallpaper::with('category')->where('category_id', $id)->withCount('likes', 'dislikes')->get();
        return view('categories.wallpaper', compact('categories', 'wallpapers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'wallpaper_image' => 'required',
            'wallpaper_image_url' => '',
        ]);
        if ($request->hasFile('wallpaper_image')) {
            $wallpaper_image = $request->file('wallpaper_image');
            $fileName =  time() . '-' . $wallpaper_image->getClientOriginalName();
            $wallpaper_image->move('assets/uploads', $fileName);
            $wallpaper_image_path = 'assets/uploads/' . $fileName;
        }

        try {
            $wal = Wallpaper::create([
                'category_id' => $request['category_id'],
                'title' => $request['title'],
                'wallpaper_image_url' => $request['wallpaper_image_url'],
                'wallpaper_image' => $wallpaper_image_path,
            ]);
            if ($wal) {
                Session::flash('success', 'Wallpaper Added Successfully!');
                return redirect()->back();
            } else {
                Session::flash('error', 'Something went wrong!');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        return Wallpaper::find($id);
    }


    public function update(Request $request, Wallpaper $wallpaper)
    {
        $data =  $request->validate([
            'title' => 'required',
            'wallpaper_image' => '',
            'category_id' => 'required',
            'wallpaper_image_url' => 'required'
        ]);

        if ($request->hasFile('wallpaper_image')) {
            $wallpaper_image = $request->file('wallpaper_image');
            $fileName =  time() . '-' . $wallpaper_image->getClientOriginalName();
            $wallpaper_image->move('assets/uploads', $fileName);
            $wallpaper_image_path = 'assets/uploads/' . $fileName;
        }

        try {
            $category = Wallpaper::find($request->wallpaper_id);

            $data['wallpaper_image'] = isset($wallpaper_image_path) ? $wallpaper_image_path : $category->wallpaper_image;
            $category->update($data);
            return redirect()->back()->with('success', 'Wallpaper Has been Updated');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());
        }
    }
    public function destroy($id)
    {
        try {
            $wallpaper = Wallpaper::find($id);
            $wallpaper->delete();
            return redirect()->back()->with('success', 'Wallpaper Has been deleted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());
        }
    }
    //    Push Notify from Admin Side.................//
    public function NotifyDetail($id)
    {
        return Wallpaper::find($id);
    }
    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = UserDevice::whereNotNull('device_token')->pluck('device_token')->all();
        $category = Wallpaper::whereId($request->wallpaper_id)->first();
        // AAAAJVC9vS8:APA91bHjLaBDeLmZNenIK18xhFhaKe8YqwRH2wOC7xpGw7JIA-orlq3OAM_cXTeilGi_ANaR0QjgCdkwAZMBz1yGPsM9PCc742QjkpGZP5Q8LMkFeFMWnhvM_BUdNtXg0mxmZJME0M-E

        $serverKey = 'AAAAhdJdnhw:APA91bG4ccNHlgsyaJV7qy2xBGuzqEYYqr4NA9q5rYgLYtcwnuE91fmyQDUL4Say9xMeIKXB2FEWzq7j870BQfusitIclBEF3ihKR_W_LJISk2VYmFu7N-GhvXugHqscvx1evZdZuMxb'; // ADD SERVER KEY HERE PROVIDED BY FCM

        $data = [

            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->notify_title,
                "id"    => $request->wallpaper_id,
                "body" => $request->body,
                // "color"=> "#53c4bc",
                "wallpaper_image" => asset($category->wallpaper_image),
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        return redirect()->back()->with('success', 'Notification send successfully');
    }
}
