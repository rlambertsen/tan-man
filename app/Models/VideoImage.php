<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoImage extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'video_images';

    protected $fillable = [
        'text',
        'episodeSeason',
        'episodeTitle',
        'episodeNumber',
        'number',
        'startTime',
        'stopTime',
        'url',
    ];
}
