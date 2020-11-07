<?php

namespace App\Http\Controllers\Dashboard;

use App\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslationController extends Controller
{

    public function updateTranslation(Request $request) {
        $translations = json_decode($request->translations);

        foreach ($translations as $item) {
            $translation = Translation::find($item->id);

            if ($translation)
                $translation->update([
                    "word_en" => $item->word_en,
                    "word_ar" => $item->word_ar,
                ]);
        }


        //return Message::success(Message::$DONE);
        return [
            "status" => 1,
            "message" => __('done')
        ];
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function show(Translation $translation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function edit(Translation $translation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translation $translation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translation $translation)
    {
        //
    }
}
