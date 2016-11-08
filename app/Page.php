<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Page extends Model
{
    protected $fillable = ['name', 'id'];
    public $incrementing = false;

    public function admins()
    {
        $admins = array();
        $role = Role::where('name', '=', $this->id . '.admin')->first();
        if ($role !== null) {
            $admins = $role->users;
        }
        return $admins;
    }

    public function _sidebar()
    {
        return $this->hasMany('App\PageSidebarLink')->orderBy('order');
    }

    public function _sidebarWhere($type)
    {
        return $this->hasMany('App\PageSidebarLink')->where('type', '=', $type)->orderBy('order');
    }

    public function sidebarPublic()
    {
        return $this->_sidebarWhere('public');
    }

    public function sidebarSubscriber()
    {
        return $this->_sidebarWhere('subscriber');
    }

    public function sidebarAdmin()
    {
        return $this->_sidebarWhere('admin');
    }

    public function addSidebarLink(PageSidebarLink $link)
    {
        $type = ucfirst($link->type);
        $link->page_id = $this->id;
        $last = Page::find($this->id)->{"sidebar$type"}->last();
        $link->order = 1;
        if ($last !== null)
            $link->order = $last->order + 1;
        $link->save();
    }

    public function deleteSidebarLink($id)
    {
        $type = ucfirst($link->type);
        $change = false;
        foreach($this->{"sidebar$type"} as $s) {
            if ($change) {
                $s->order -= 1;
                $s->save();
            }
            if ($id === $s->id) {
                $change = true;
                $s->delete();
            }
        }
    }

    public function reorderSidebarLinks()
    {
        $type = ucfirst($link->type);
        $order = 1;
        foreach($this->{"sidebar$type"} as $s) {
            $s->order = $order;
            $order += 1;
            $s->save();
        }
    }

    public function addAdmin(User $user)
    {
        if (!$user->hasRole($this->id . '.admin'))
            $user->assignRole($this->id . '.admin');
    }

    public function deleteAdmin(User $user)
    {
        $user->removeRole($this->id . '.admin');
    }

    public function subscribers()
    {
        $subscribers = array();
        $role = Role::where('name', '=', $this->id . '.subscriber')->first();
        if ($role !== null) {
            $subscribers = $role->users;
        }
        return $subscribers;
    }

    public function addSubscriber(User $user)
    {
        $user->assignRole($this->id . '.subscriber');
    }

    public function deleteSubscriber(User $user)
    {
        $user->removeRole($this->id . '.subscriber');
    }

    public function notifications()
    {
        return $this->hasMany('App\PageNotification')->orderBy('updated_at', 'desc');
    }

    public function addPublicPageNotification($content)
    {
        $notif = new PageNotification();
        $notif->page_id = $this->id;
        $notif->content = $content;
        $notif->save();

        return $notif;
    }

    public function addPageNotification($content)
    {
        $notif = $this->addPublicPageNotification($content);

        foreach($this->subscribers() as $subscriber)
            $this->addUserNotification($subscriber, $content, $notif->id);
    }

    public function addUserNotification($user, $content, $global)
    {
        $unotif = new UserNotification();
        $unotif->page_id = $this->id;
        $unotif->user_id = $user->id;
        $unotif->page_notification_id = $global;
        $unotif->content = $content;
        $unotif->read = false;
        $unotif->save();
    }

    public function addPersonalNotification($user, $content)
    {
        $this->addUserNotification($user, $content, 0);
    }

    public function modules()
    {
        return $this->hasMany('App\PageModule');
    }

    public function modulesQuery($type)
    {
        return $this->modules()->where('type', '=', $type)->get();
    }


    public function staticPages()
    {
        $ret = array();
        foreach($this->modulesQuery('StaticPage') as $m) {
            $s = StaticPage::where('page_module_id', '=', $m->id)->first();
            $sidebar = $this->_sidebar()->where('page_module_id', '=', $m->id)->first();
            $s->name = $sidebar->name;
            array_push($ret, $s);
        }
        return $ret;
    }


    public function addModule($module, $config = ['immutable' => true, 'type' => 'public'])
    {
        $immutable = false;
        if (isset($config['immutable']))
            $immutable = $config['immutable'];

        $type = 'public';
        if (isset($config['type']))
            $type = $config['type'];

        $side = isset($config['link']) && isset($config['name']) && isset($config['icon']);

        if ($side) {
            $link = $config['link'];
            $name = $config['name'];
            $icon = $config['icon'];
        }

        $class = substr(get_class($module), 4);
        $P = new PageModule();
        $P->page_id = $this->id;
        $P->type = $class;

        $P->immutable = $immutable;

        $P->save();
        $module->page_module_id = $P->id;
        if (!in_array($class, ['PageNotifications', 'PageSettings']))
            $module->save();

        if (!$side)
            return;

        $sidebar = new \App\PageSidebarLink();
        $sidebar->link = $link;
        $sidebar->icon = $icon;
        $sidebar->name = $name;
        $sidebar->type = $type;
        $sidebar->page_module_id = $P->id;
        $this->addSidebarLink($sidebar);
    }

    public function addHomepage()
    {
        $S = new StaticPage();
        $S->link = 'home';

        $config = [
                    'immutable' => true,
                    'type' => 'public',
                    'name' => 'Home',
                    'link' => 'home',
                    'icon' => 'fa-home'
                  ];

        $this->addModule($S, $config);
        \Storage::disk('local')->put('pages/' . $this->id . '/static/home', '# ' . $this->name);
    }

    public function initialize()
    {
        $this->addHomepage();
        $this->addModuleResults();

        $n = new \App\PageNotifications();
        $config = [
            'immutable' => true,
            'type' => 'public',
            'name' => 'Notifications',
            'link' => 'notifications',
            'icon' => 'fa-bell'
        ];
        $this->addModule($n, $config);

        $s = new \App\PageSettings();
        $config = [
            'immutable' => true,
            'type' => 'admin',
            'name' => 'Settings',
            'link' => 'settings',
            'icon' => 'fa-cogs'
        ];
        $this->addModule($s, $config);
    }

    public function delete()
    {
        \Storage::deleteDirectory('pages/' . $this->id);

        $haveNoTable = ['PageNotifications', 'PageSettings'];
        foreach($this->modules as $module) {
            $module->delete();
            if (in_array($module->type, $haveNoTable))
                continue;
            $tmp = "\App\\" . $module->type;
            $tmp::where('page_module_id', '=', $module->id)->delete();
        }

        foreach($this->notifications as $n)
            $n->delete();

        // foreach($this->subscribers() as $subscriber)
            // $subscriber->pageNotifications($this)->delete();

        $this->_sidebar()->delete();
        parent::delete();

        $role = Role::where("name", "=", $this->id . ".admin")->first();
        $role->delete();

        $role = Role::where("name", "=", $this->id . ".subscriber")->first();
        $role->delete();
    }

    public function permutateSidebar($params)
    {
        $names = [
            'publicSidebarLink' => 'public',
            'subscriberSidebarLink' => 'subscriber',
            'adminSidebarLink' => 'admin'
        ];

        foreach($names as $key => $l) {
            $list = $params[$key];
            $type = ucfirst($l);
            $s = Page::find($this->id)->{"sidebar$type"};

            $order = 1;
            foreach($s as $link) {
                $order = array_search(intval($link->order), $list);
                if ($link->order === false)
                    return 'error';
            }

            foreach($s as $link) {
                $link->order = array_search(intval($link->order), $list) + 1;
                $link->save();
            }
        }

        return 'success';
    }

    public function resultPages()
    {
        $m=$this->modulesQuery('PageResult')->first();
        $s = PageResult::where('page_module_id', '=', $m->id)->first();
        return $s;
    }

    public function addModuleResults()
    {
        $r = new PageResult();
        $r->link = 'results';
        $config = [
            'immutable' => false,
            'type' => 'subscriber',
            'name' => 'Results',
            'link' => 'results',
            'icon' => 'fa-table'
        ];
        $this->addModule($r, $config);
        \Storage::disk('local')->makeDirectory('pages/' . $this->id . '/results/');
    }

    public function testPages()
    {
        $ret = array();
        foreach($this->modulesQuery('PageTest') as $m) {
            $s = PageTest::where('page_module_id', '=', $m->id)->first();
            $sidebar = $this->_sidebar()->where('page_module_id', '=', $m->id)->first();
            $s->name = $sidebar->name;
            array_push($ret, $s);
        }
        return $ret;
    }

    public function addTest()
    {
        $S = new PageTest();
        $S->link = 'test';
        $S->isSetTest = false;
        $S->numTasks = 0;

        $config = [
                    'immutable' => true,
                    'type' => 'subscriber',
                    'name' => 'Test',
                    'link' => 'test',
                    'icon' => 'fa-calculator'
                  ];

        $this->addModule($S, $config);
    }
}
