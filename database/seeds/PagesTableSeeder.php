<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = new App\Page();
        $page->id = 'rp2';
        $page->name = 'Racunarski Praktikum 2';
        $page->save();
        Role::create(["name" => "rp2.admin"]);
        Role::create(["name" => "rp2.subscriber"]);

        $admin = App\User::where('email', '=', 'john@doe.com')->first();
        $admin->assignRole('rp2.admin');

        $subscriber = App\User::where('email', '=', 'jane@doe.com')->first();
        $subscriber->assignRole('rp2.subscriber');

        $page->addPageNotification('Obavijest svim ljudima dobre volje');
        $page->addPersonalNotification($subscriber, 'Obavijest za Jane Doe');
        $page->initialize();

        $page = new App\Page();
        $page->id = 'mii';
        $page->name = 'Mjera i Integral';
        $page->save();
        Role::create(["name" => "mii.admin"]);
        Role::create(["name" => "mii.subscriber"]);
        $admin->assignRole('mii.subscriber');

        $page->initialize();
        $page->addPersonalNotification($admin, 'Mjerna obavijest Johnu Doeu dobre volje');

        $page = new App\Page();
        $page->id = 'stat';
        $page->name = 'Statistika';
        $page->save();
        Role::create(["name" => "stat.admin"]);
        Role::create(["name" => "stat.subscriber"]);
        $admin->assignRole('stat.admin');

        $page->initialize();
    }
}
