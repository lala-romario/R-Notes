<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{
    public function index(Request $request)
    {
        //$id = $request->user()->note;
        $userToken = $request->header('Authorization');

        $user = DB::table('users')->where('token', $userToken)->first();

        if (! $user) {
            return [
                'error' => 'errror',
                'code' => 402
            ];
        }

        $notes = DB::table('notes')->where('user_id', $user->id)->get();

        return [
            'notes' => $notes,
            'user' => $user,
            'code' => 200
        ];
    }

    public function store(Request $request)
    {
        $userToken = $request->header('Authorization');

        $user = DB::table('users')->where('token', $userToken)->first();

        if (! $user) {
            return [
                'error' => 'you are not an user',
                'code' => 402
            ];
        }
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

        $validated['user_id'] = $user->id;

        $note = Note::create($validated);

        return [
            'success' => 'its work',
            'filename' => new NoteResource($note),
            'user' => $user,
        ];
    }
}
