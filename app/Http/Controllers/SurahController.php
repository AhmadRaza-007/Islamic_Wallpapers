<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Quran;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SurahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Surah::create([
            'book_id' => $request->book_id,
            'surah_number' => $request->surah_number,
            'surah' => $request->surah,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function show(surah $surah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Surah::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required',
            'surah_number' => 'required',
            'surah' => 'required',
        ]);

        try {
            Surah::find($request->surah_hidden)->update($data);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return Surah::find($id);
        // Surah::find($id)->delete();
        // return redirect()->back();
    }
}
