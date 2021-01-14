<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return auth()->user()->notes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:50',
            'note' => 'required|max:1000',
        ]);

        $post = $request->user()->notes()->create([
            'title' => $request->title,
            'note' => $request->note
        ]);

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $note = auth()->user()->notes->find($id);
        $this->authorize('view', $note); // Verify against NotePolicy
        return $note;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $note = $request->user()->notes()->where('id', $id)->first();
        $this->authorize('update', $note); // Verify against NotePolicy

        $this->validate($request, [
            'title' => 'max:50',
            'note' => 'max:1000',
        ]);

        $note->update($request->all());
        return $note;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $note = auth()->user()->notes->find($id);
        $this->authorize('delete', $note); // Verify against NotePolicy

        $note->delete();
        return $note;
    }
}
