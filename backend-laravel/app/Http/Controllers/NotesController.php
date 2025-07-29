<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function index() {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $note = Note::create($validated);
        
        return [
            'success' => 'its work',
            'note' => new NoteResource($note)
        ];
    }
}
