<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;

class NotificationsController extends Controller
{
    public function pageNotifications(Page $page)
    {
        if (\Auth::check() && \Auth::user()->hasRole($page->id . '.subscriber')) {
            $notifications = \Auth::user()->pageNotifications($page);
        } else {
            $notifications = $page->notifications;
        }
        return view('pages.notifications', compact('page', 'notifications'));
    }

    public function userNotifications()
    {
        $notifications = \Auth::user()->notifications;
        return view('user.notifications', compact('notifications'));
    }


    public function addPageNotification(Request $request, Page $page)
    {
        \Session::flash('message', 'Notification content should be at least 2 characters long');
        \Session::flash('alert-class', 'alert-danger');

        $this->validate($request, [
            'content' => 'required|min:2|max:255',
        ]);

        \Session::flash('message', 'Notification created successfully!');
        \Session::flash('alert-class', 'alert-success');

        $page->addPageNotification($request->content);
        return back();
    }
}
