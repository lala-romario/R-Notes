<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
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
                'code' => 403
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

            $recordedVideo = $request->file('recordedVideo');
            $videoOriginalName = pathinfo($recordedVideo->getClientOriginalName(), PATHINFO_FILENAME);

            //convertion webm to mp4
            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/bin/ffprobe'
            ]);
            //
            $video = $ffmpeg->open($recordedVideo);

            $format = new X264('libmp3lame', 'libx264');

            $video->save($format, storage_path("app/public/{$videoOriginalName}.mp4"));
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('file')) {
            $validated['file_URL'] = asset('storage/' . $path_file);
            $validated['originalFileName'] = $originalFileName;
        }

        if ($request->hasFile('recordedVideo')) {
            $validated['video'] = asset('storage/' . "/{$videoOriginalName}.mp4");
        }

        $validated['user_id'] = $user->id;

        $note = Note::create($validated);

        return [
            'success' => 'its work',
            'Note' => new NoteResource($note),
            'user' => $user,
        ];
    }

    public function destroy(Request $request)
    {
        $userToken = $request->header('Authorization');

        $user = DB::table('users')->where('token', $userToken)->first();

        if (! $user) {
            return [
                'code' => 403
            ];
        }
        $noteId = $request['noteId'];

        Note::destroy($noteId);

        return [
            'code' => 200
        ];
    }
}
