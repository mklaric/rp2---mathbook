<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function subscribed()
    {
        $roles = $this->roles()->where('name', 'LIKE', '%.subscriber')->pluck('name');
        $subscribed = array();
        foreach ($roles as $role) {
            $name = preg_replace('/(.)\.subscriber/', '$1', $role);
            $page = \App\Page::where('id', '=', $name)->first();
            array_push($subscribed, $page);
        }
        return $subscribed;
    }

    public function administrated()
    {
        $roles = $this->roles()->where('name', 'LIKE', '%.admin')->pluck('name');
        $administrated = array();
        foreach ($roles as $role) {
            $name = preg_replace('/(.)\.admin/', '$1', $role);
            $page = \App\Page::where('id', '=', $name)->first();
            array_push($administrated, $page);
        }
        return $administrated;
    }

    public function notifications()
    {
        return $this->hasMany('App\UserNotification')->orderBy('updated_at', 'desc');
    }

    public function pageNotifications($page)
    {
        return $this->hasMany('App\UserNotification')->where('page_id', '=', $page->id)->orderBy('updated_at', 'desc')->get();
    }

    public function unreadNotificationsNumber()
    {
        return $this->hasMany('App\UserNotification')->where('read', '=', false)->count();
    }

    public function fileentries()
    {
        return $this->hasMany('App\Fileentry')->orderBy('task_id');
    }
}
