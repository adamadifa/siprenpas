<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover',
    ];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'gallery_album_id');
    }
}


