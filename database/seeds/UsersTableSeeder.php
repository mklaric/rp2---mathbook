<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new App\User();
        $admin->name = 'John Doe';
        $admin->email = 'john@doe.com';
        $admin->password = bcrypt('password');
        $admin->save();

        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $admin = new App\User();
        $admin->name = 'Jane Doe';
        $admin->email = 'jane@doe.com';
        $admin->password = bcrypt('password');
        $admin->save();
    }
}
