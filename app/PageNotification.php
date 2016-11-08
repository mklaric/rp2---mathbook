<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageNotification extends Model
{
    public function page()
    {
        return $this->belongsTo('App\Page');
    }
}
