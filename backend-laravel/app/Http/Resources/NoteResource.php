<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'file_URL' => $this->file_URL,
            'video' => $this->video,
            'originalFileName' => $this->originalFileName,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
