<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCaption extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'video_captions';

    protected $fillable = [
        'text',
        'episodeID',
        'number',
        'startTime',
        'stopTime',
    ];
}
