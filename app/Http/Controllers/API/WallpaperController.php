<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallpaper;
use Illuminate\Http\Request;

class WallpaperController extends Controller{
    public function index(Request $request)
    {
        $inputs= $request->validate([
            'limit' => '',
            'device_token' => '',
        ]);
        if($inputs){
            $chek_device = UserDevice::whereDeviceToken($request->device_token)->first();
                if (!empty($chek_device)) {
                    $chek_device->update([
                        'logged_in' => 1,
                    ]);
                }else{
                    UserDevice::create([
                        'device_token' => $request->device_token,
                        'logged_in' => 1
                    ]);
                }
                
            $wallpapers=Category::with(['wallpapers'=>function($q){
                $q->withCount('likes')->orderBy('id', 'desc');
            }])->get()->map(function ($cat)use($request){
                $cat->setRelation('wallpapers', $cat->wallpapers->take($request->limit)->map(function ($q)use($request){
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
                })) ;
                return $cat;
            });
            return response()->json([
                'status'=>'success',
                'data'=>$wallpapers
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' =>'invalid Param limit'
            ]);
        }
    }

    public function wallpapersByCategory(Request $request)
    {
        $inputs = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'page' => '',
            'limit' => ''
        ]);
        if($inputs){
            $page= $request->page-1;
            $category=Category::whereid($request->category_id)->with(['wallpapers'=>function($q)use($request,$page){
                $q->whereCategoryId($request->category_id)->withCount('likes')->offset($request->limit*$page)->take($request->limit);
            }])->get()->map(function ($cat)use($request){
                $cat->setRelation('wallpapers', $cat->wallpapers->map(function ($q)use($request){
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
                }));
                return $cat;
            });
            return response()->json([
                'status' => 'success',
                'data' => $category
            ]);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => ''
            ]);
        }
    }

}
