<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Vote;
use Illuminate\Foundation\Auth\User;

class IdeaController extends Controller
{

    public function index()
    {


        //each idea will contain an attribut called votes_count
        //
        return view("idea.index");
    }

    public function show(Idea $idea)
    {
        return view(
            "idea.show",
            [
                "idea" => $idea,
                "votesCount" => $idea->votes->count(),
                'backUrl' => url()->previous() !== url()->full()
                ? url()->previous()
                : route('idea.index'),
            ]
        );
    }

  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        //
    }
}