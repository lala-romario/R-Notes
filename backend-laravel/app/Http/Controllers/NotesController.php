<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function index()
    {
        $note = Note::all();

        return $note;
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required'
        ];

        if ($request->hasFile('file')) {
            $rules['file'] = 'mimes:jpg,png,mp4,webm|max:2048';
            $path_file = $request->file('file')->store('files', 'public');
            $originalFileName = $request->file('file')->getClientOriginalName();
        }

        if ($request->hasFile('recordedVideo')) {
            $rules['video'] = 'mimes:webm|max:10248';
            $path_video = $request->file('recordedVideo')->store('video', 'public');
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('file')) {
            $validated['file_URL'] = asset('storage/' . $path_file);
            $validated['originalFileName'] = $originalFileName;
        }

        if ($request->hasFile('recordedVideo')) {
            $validated['video'] = asset('storage/' . $path_video);
        }

        $note = Note::create($validated);

        return [
            'success' => 'its work',
            'filename' => new NoteResource($note)
        ];
    }
}
