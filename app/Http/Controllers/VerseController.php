<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Language;
use App\Models\Surah;
use App\Models\Verse;
use App\Models\Verse_language;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class VerseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::find(1);
        $book->surah->map(function ($surah) {
            echo ($surah->verse);
        })->flatten();
        print_r($book);
        // return view('Books.verse');
    }

    public function verse($id, $num = null)
    {
        // isset($num) ?
        // $verse = Verse_language::with('verse', 'language')->where('surah_id', $id)->where('language_id', 1)->get();
        // //  :
        // // $verse = Verse_language::with('verse', 'language')->where('surah_id', $id)->get();


        // $translate = Verse::where('surah_id', $id)->where('language_id', $num)->get();
        // // return $translate[0];
        // $surah = Surah::whereId($id)->get();
        // $languages = Language::orderBy('language')->get();

        // for ($index = 0; $index < $verse->count(); $index++) {

        //     $verse[$index]->verse->translate = $translate[$index]->verse;
        // }
        for ($i = 10; $i < 100; $i++) {
            $this->downloadFiles($i);
            // echo '<h1>' . $i . '</h1>';
        }
        // return view('Books.verse', compact('surah', 'verse', 'languages', 'id'));
    }

    public function downloadFiles($index)
    {
        if ($index > 0) {

            $url = 'https://archive.org/download/aziz.quranhousebd/0020' . $index . '.mp3';
            $fileContents = Http::get($url)->body();

            $fileName = '0020' . $index . '.mp3';
            $filePath = 'public/' . $fileName; // Adjust the path as needed

            // Save the file to the local storage
            Storage::put($filePath, $fileContents);

            return $filePath;
        }
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
        // return $request->all();
        $data = $request->validate([
            'surah_id' => 'required',
            'verse_number' => 'required',
            'verse' => 'required',
            'language_id' => 'required',
        ]);
        // return $data;
        // $verse = Verse::create($data);
        // Verse_language::create([
        //     'verse_id' => $verse->id,
        //     'language_id' => isset($request->language) ?? 0,
        // ]);
        // return $request->verse_number;
        foreach ($request->verse as $key => $verse) {
            // echo $request->language_id[$key] . ' ' . $key . ' ' . '<br>';

            $storeData = Verse::create([
                'surah_id' => $request->surah_id,
                'verse_number' => $request->verse_number,
                'verse' => $verse[$key],
                'language_id' => $request->language_id[$key],
            ]);

            Verse_language::create([
                'surah_id' => $request->surah_id,
                'verse_id' => $storeData->id,
                'language_id' => $request->language_id[$key],
            ]);
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Verse  $verse
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Verse  $verse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Verse::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Verse  $verse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'surah_id' => 'required',
            'verse_number' => 'required',
            'verse' => 'required',
        ]);
        // return $request->all();
        try {
            Verse::find($request->verse_hidden)->update($data);
            Verse_language::where('verse_id', $request->verse_hidden)->update([
                'surah_id' => $request->surah_id,
                'language_id' => $request->language_id,
            ]);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Verse  $verse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verse::find($id)->delete();
        // Verse_language::where('verse_id', $id)->delete();
        // return redirect()->back();
    }
}
