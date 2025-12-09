<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PilarPendidikanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_pilar' => $this->nama_pilar,
            'deskripsi' => $this->deskripsi,
            'urutan' => $this->urutan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

