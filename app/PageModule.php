<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageModule extends Model
{
    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function sidebarLink()
    {
        return $this->hasOne('App\PageSidebarLink');
    }
}
