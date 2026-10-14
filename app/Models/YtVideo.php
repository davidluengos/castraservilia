<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YtVideo extends Model
{
    protected $table = 'ytvideo';
    public $timestamps = false;

    public function embedUrl(): string
    {
        return 'https://www.youtube.com/embed/' . $this->idyt;
    }
}
