<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTest extends Model
{
    public function pageModule()
    {
        return $this->belongsTo('App\PageModule')->first();
    }

    public function tasks()
    {
        return $this->hasMany('App\Task')->orderBy('id');
    }
}
