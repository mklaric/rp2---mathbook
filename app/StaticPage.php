<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    public function pageModule()
    {
        return $this->belongsTo('App\PageModule')->first();
    }

    public static function _create($name, $link, $page)
    {
        $s = new static();
        $s->link = $link;

        $config = [
            'immutable' => false,
            'type' => 'public',
            'name' => $name,
            'link' => $link,
            'icon' => 'fa-home'
        ];

        $page->addModule($s, $config);
        \Storage::disk('local')->put('pages/' . $page->id . '/static/' . $s->link, '# ' . $name);
    }

    public static function _delete($id, $page)
    {
        $static = StaticPage::where('id', '=', $id)->first();
        PageModule::where('id', '=', $static->page_module_id)->delete();
        PageSidebarLink::where('page_module_id', '=', $static->page_module_id)->delete();
        \Storage::disk('local')->delete('pages/' . $page->id . '/static/' . $static->link);
        $static->delete();
    }

    public static function _edit($module, $page, $params)
    {
        $name = $params['name'];
        $link = $params['link'];
        $icon = $params['icon'];
        $content = $params['content'];

        if ($name !== null && $name !== $module->pageModule()->sidebarLink()->first()->name) {
            $m = $module->pageModule()->sidebarLink()->first();
            $m->name = $name;
            $m->save();
        }

        if ($link !== null && $link !== $module->link) {
            if ($link === 'home')
                return 'error';
            if ($module->pageModule()->sidebarLink()->first()->link === 'home')
                return 'error';
            $path = 'pages/' . $page->id . '/static/';
            \Storage::disk('local')->move($path . $module->link, $path . $link);

            $module->link = $link;
            $module->save();

            $m = $module->pageModule()->sidebarLink()->first();
            $m->link = $link;
            $m->save();
        }

        if ($icon !== null) {
            if (!IconSet::exists($icon))
                return 'error';
            $m = $module->pageModule()->sidebarLink()->first();
            $m->icon = $icon;
            $m->save();
        }

        if ($content !== null) {
            \Storage::disk('local')->put('pages/' . $page->id . '/static/' . $module->link, $content);
        }

        return 'success';
    }
}
