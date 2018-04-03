<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['img_url', 'simg_url', 'topic_id', 'status', 'type'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
