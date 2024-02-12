<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Surah;
use App\Models\Verse;
use App\Models\Verse_language;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::get();
        // ini_set('memory_limit', '5006M');
        // $books = File::get(public_path('assets/quran.json'));
        // // return $books[0];
        // $data = json_decode($books, true);
        // $surah = File::get(public_path('assets/surat.json'));
        // $data2 = json_decode($surah, true);
        // $a = $data[0];
        // // return $a['content_en'];
        // $ss1 = $data[1];
        // $ss2 = $data[7];
        // $val = 0;
        // // return $data[0];
        // $val = ($data[0]['sura name'] == $data[6]['sura name']) ? 1 : 2;

        // for ($i = 0; $i < 6400; $i++) {
            // $chapter = 0;
            // if ($data[0]['chapter_number'] == $data[$i]['chapter_number']) {

            // }else{
            //     // echo 'hello: ' . $i . ' : ' . $data[$i]['content_ar'] . '<br>';
            //     $chapter = $data[$i]['chapter_number'];
            //     continue;
            // }
            // Surah::create([
            //     'book_id' => 1,
            //     'surah_number' => $data2[$i]['surah'],
            //     'surah' => $data2[$i]['name'],
            // ]);


            // $language_id = 30;
            // $storeData = Verse::create([
            //     'surah_id' => $data[$i]['chapter_number'],
            //     'verse_number' => $data[$i]['Ayah_number'],
            //     'verse' => $data[$i]['content_en_tr'],
            //     'language_id' => $language_id,
            // ]);

            // Verse_language::create([
            //     'surah_id' => $data[$i]['chapter_number'],
            //     'verse_id' => $storeData->id,
            //     'language_id' => $language_id,
            // ]);



            // echo 'hello: ' . $data[$i]['Ayah_number'] . ' : ' . $data[$i]['content_en_tr'] . '<br>';
            // echo 'hello: ' . $data2[$i]['surah'] . ' : ' . $data2[$i]['name'] . '<br>';
        // }
        // return $val;
        return response()->json([
            'Books' => $books,
        ]);
    }

    public function book($id)
    {
        $book = Book::with('surah')->whereId($id)->first();
        // return view('Books.surah', compact('book'));
        return response()->json([
            'data' => $book,
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
