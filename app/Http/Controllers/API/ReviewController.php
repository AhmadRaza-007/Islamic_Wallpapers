<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Wallpaper;
use App\Models\WallpaperDislike;
use App\Models\WallpaperFavourite;
use App\Models\WallpaperLike;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function likes(Request $request){
        $request->validate([
            'user_id'     => 'required',
            'wallpaper_id'     => 'required',
        ]);
        try {
            $like_user=WallpaperLike::whereUserId($request->user_id)->whereWallpaperId($request->wallpaper_id)->first();
            if($like_user){
                WallpaperLike::whereUserId($request->user_id)->whereWallpaperId($request->wallpaper_id)->delete();
                return  response()->json([
                    "status"     =>'like removed successfully',
                    "message" => trans("wallpaper's Like has been removed")
                ]);
            }
            $like= WallpaperLike::create([
                'user_id' => $request['user_id'],
                'wallpaper_id' => $request['wallpaper_id'],
            ]);
            return  response()->json([
                "status"     =>'like successfully',
                "message" => ("wallpaper like successfully"),
            ]);
        }catch (\Exception $e) {
            return  $e->getMessage() . "on line" . $e->getLine();
        }
    }

    public function dislikes(Request $request){
        $request->validate([
            'user_id'     => 'required',
            'wallpaper_id'     => 'required',
        ]);
        try {
            $dislike_user=WallpaperDislike::whereUserId($request->user_id)->whereWallpaperId($request->wallpaper_id)->first();
            if($dislike_user){
                WallpaperDislike::whereUserId($request->user_id)->whereWallpaperId($request->wallpaper_id)->delete();
                return  response()->json([
                    "status"     =>'dislike removed successfully',
                    "message" => "wallpaper's Like has been removed"
                ]);
            }
            $dislike= WallpaperDislike::create([
                'user_id' => $request['user_id'],
                'wallpaper_id' => $request['wallpaper_id'],
            ]);
            return  response()->json([
                "status"     =>'dislike successfully',

                "user"   =>$dislike,
            ]);
        }catch (\Exception $e) {
            return  $e->getMessage() . "on line" . $e->getLine();

        }
    }
    public function getFavouritWallpapers(Request $request){
       $inputs= $request->validate([
            'limit'     => 'required',
        ]);

        if($inputs){
            $user=User::whereId($request->user_id)->first();
           $favrtWallpapers=$user->userWallpapers()->pluck('wallpaper_id');
            $wallpaperFavrts=Wallpaper::whereIn('id',$favrtWallpapers)->withCount('likes')->get()
               ->map(function ($q)use($request){
                 if($request->user_id){
                        $fav = $q->favrouteByUser($request->user_id);
                         $lik = $q->likeByUser($request->user_id);
                        if($fav->count() > 0){
                            $q["user_favroute"] = true;
                        }else{
                            $q["user_favroute"] = false;
                        }
                           if($fav->count() > 0){
                            $q["user_liked"] = true;
                        }else{
                            $q["user_liked"] = false;
                        }
                    }
                    else{
                        $q["user_favroute"] = false;
                         $q["user_liked"] = false;
                    }
               return $q;
           });
            return  response()->json([
                "status"     =>' success',
                "wallpaper"   =>$wallpaperFavrts,
            ]);
        }else{
            return  response()->json([
                "status"     =>'failed',
                "message"   =>"invalid param's",
            ]);
        }
    }
    public function favourites(Request $request){
        $request->validate([
            'user_id'     => 'required',
            'wallpaper_id'     => 'required',
        ]);
        try {
            $like_user=WallpaperFavourite::whereUserId($request->user_id)->whereWallpaperId($request->wallpaper_id)->first();
            if($like_user){
                WallpaperFavourite::whereUserId($request->user_id)->whereWallpaperId($request->wallpaper_id)->delete();
                return  response()->json([
                    "status"     =>'WallpaperFavourite removed successfully',
                    "message" => trans("Wallpaper Favourite's  has been removed")
                ]);
            }
            $fav= WallpaperFavourite::create([
                'user_id' => $request['user_id'],
                'wallpaper_id' => $request['wallpaper_id'],
            ]);
            return  response()->json([
                "status"     =>'like successfully',
                "message" => trans("Wallpaper Favourite's successfully"),
            ]);
        }catch (\Exception $e) {
            return  $e->getMessage() . "on line" . $e->getLine();

        }
    }
}
