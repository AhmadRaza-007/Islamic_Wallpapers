<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Wallpaper;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ]);
    }

    public function detail(Request $request)
    {
        $inputs = $request->validate([
            'wallpaper_id' => 'required',
            'user_id'      => '',
            'limit'        => '',
            'page'         => ''
        ]);
        $page = $request->page - 1;
        $first = '';
        $tempArray = [];
        $wallpaper = Wallpaper::whereId($request->wallpaper_id)->first();
        $category = $wallpaper->category()->first();
        $wallpapers = $category->wallpapers()->withCount('likes')->get()->map(function ($q) use ($request, &$first, &$tempArray) {
            if ($request->user_id) {
                $fav = $q->favrouteByUser($request->user_id);
                $lik = $q->likeByUser($request->user_id);
                if ($fav->count() > 0) {
                    $q["user_favroute"] = true;
                    //  $q["user_liked"] = true;
                } else {
                    $q["user_favroute"] = false;
                    //  $q["user_liked"] = true;
                }
                if ($lik->count() > 0) {
                    $q["user_liked"] = true;
                } else {
                    $q["user_liked"] = false;
                }
            } else {
                $q["user_favroute"] = false;
                $q["user_liked"] = false;
            }
            if ($request->wallpaper_id == $q['id']) {
                $first = $q;
            } else {
                $tempArray[] = $q;
            }
            return  $q;
        });
        $ArrangedWallpapers[] = $first;
        foreach ($tempArray as $val) {
            $ArrangedWallpapers[] = $val;
        }
        $LimitedArrangedWallpapers = array_slice($ArrangedWallpapers, $request->limit * $page, $request->limit);

        return response()->json([
            'status' => 'success',
            'wallpapers' => $LimitedArrangedWallpapers
        ]);
    }
}
