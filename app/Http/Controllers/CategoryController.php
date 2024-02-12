<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('order', 'asc')->get();
        return view('categories.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            Category::create([
                'name' => $request->name,
            ]);
            $url = 'https://fcm.googleapis.com/fcm/send';

            $FcmToken = UserDevice::whereNotNull('device_token')->pluck('device_token')->all();


            $serverKey = 'AAAAhdJdnhw:APA91bG4ccNHlgsyaJV7qy2xBGuzqEYYqr4NA9q5rYgLYtcwnuE91fmyQDUL4Say9xMeIKXB2FEWzq7j870BQfusitIclBEF3ihKR_W_LJISk2VYmFu7N-GhvXugHqscvx1evZdZuMxb'; // ADD SERVER KEY HERE PROVIDED BY FCM

            $data = [

                "registration_ids" => $FcmToken,
                "notification" => [
                    "title" => 'category Updated',
                    "body" =>  "update msg from user",
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

            Session::flash('success', 'Category Add Successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            Session::flash('error', 'Category Add failed!');
            return redirect()->back();
        }
    }

    public function updateOrder(Request $request)
    {
        $posts = Category::all();
        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }
    }
    public function edit($id)
    {
        return Category::find($id);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);


        try {
            $category = Category::find($request->category_id);
            $category->update($data);
            Session::flash('success', 'Category Has been Updated!');
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    public function destroy($id)
    {
        $userCount = Category::find($id)->wallpapers->count();
        if ($userCount > 0) {
            Session::flash('error', 'Category has ' . $userCount . ' wallpapers');
            return redirect()->back();
        } else {
            Category::whereId($id)->delete();
            Session::flash('success', 'Category has been Deleted');
            return redirect()->back();
        }
    }
}
