<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataImage extends Model
{
    protected $table = 'dataimage';
    public $timestamps = false;

    public function url(): string
    {
        return url('uploads/' . $this->item_type . '/' . $this->item_id . '/' . $this->filename);
    }
}
