<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Language;
use App\Models\Surah;
use App\Models\User;
use App\Models\Verse;
use App\Models\Verse_language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SurahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $surah = Surah::get();

            return response()->json([
                'status' => 'Success',
                'data' => $surah,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'Error',
                'message' => throw $exception->getMessage() . ' ' . $exception->getLine(),
            ]);
        }
    }

    public function surah(Request $request, $id, $lang = '1')
    {
        try {

            $translate = Verse::where('surah_id', $id)->where('language_id', $lang)->get();

            $surah = Surah::with(['verses' => function ($q) use ($lang) {
                $q->where('language_id', 1);
            }])->whereId($id)->first();

            if ($surah) {
                foreach ($surah->verses as $key => $verse) {
                    $verse->translate = $translate[$key]->verse;
                }
            }

            try {
                return response()->json([
                    'status' => 'Success',
                    'data' => $surah,
                ]);
            } catch (Exception $exception) {
                return response()->json([
                    'status' => 'Error',
                    'message' => throw $exception->getMessage() . ' ' . $exception->getLine(),
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'Error',
                'message' => throw $exception->getMessage() . ' ' . $exception->getLine(),
            ], 500);
        }
    }

    public function verse($id, $num = 1)
    {
        $mainLanguageId = 1;
        $relatedLanguageId = 3; // Change this to the desired language_id

        $lang = Verse::where('language_id', 2)->get('verse');
        // return $lang->verse;

        $verses = Verse::where('language_id', $mainLanguageId)->get('verse');

        // return $verses->count();
        for ($index = 0; $index < $verses->count(); $index++) {
            $verses[$index]->translate = $lang[$index]->verse;
        }
        // Add the manually created verse to the collection
        // $verses[0]->translate = $lang[0];
        return response()->json([
            'status' => 'Success',
            'data' => $verses,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
