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
        $rules = [
            'title' => 'required',
            'content' => 'required'
        ];

        if ($request->hasFile('file')) {
            $rules['file'] = 'mimes:jpg,png,mp4,webm|max:2048';
            $path = $request->file('file')->store('files', 'public');
        }
        $validated = $request->validate($rules);
        $validated['file'] = $path;

        $note = Note::create($validated);

        return [
            'success' => 'its work',
            'filename' => new NoteResource($note)
        ];
    }
}
