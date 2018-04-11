<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moderator = Role::create([
            'name' => 'Moderator', 
            'slug' => 'moderator',
            'permissions' => [
                'create-post' => true,
            ]
        ]);
        $admin = Role::create([
            'name' => 'Admin', 
            'slug' => 'admin',
            'permissions' => [
                'update-post' => true,
                'publish-post' => true,
            ]
        ]);
        $developer = Role::create([
            'name' => 'Developer', 
            'slug' => 'developer',
            'permissions' => [
                'update-post' => true,
                'publish-post' => true,
            ]
        ]);
        $eventmanager = Role::create([
            'name' => 'Eventmanager', 
            'slug' => 'eventmanager',
            'permissions' => [
                'update-post' => true,
                'publish-post' => true,
            ]
        ]);

    }
}
