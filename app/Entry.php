<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
