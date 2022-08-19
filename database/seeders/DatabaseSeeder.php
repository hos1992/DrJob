<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\User::truncate();
        \App\Models\Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Category::firstOrCreate(['name' => 'php']);
        Category::firstOrCreate(['name' => 'laravel']);
        Category::firstOrCreate(['name' => 'my sql']);

        $usersPermissions = [
            ['name' => 'index-user', 'guard_name' => 'web'],
            ['name' => 'show-user', 'guard_name' => 'web'],
            ['name' => 'create-user', 'guard_name' => 'web'],
            ['name' => 'edit-user', 'guard_name' => 'web'],
            ['name' => 'delete-user', 'guard_name' => 'web'],
        ];

        $postsPermissions = [
            ['name' => 'index-post', 'guard_name' => 'web'],
            ['name' => 'show-post', 'guard_name' => 'web'],
            ['name' => 'create-post', 'guard_name' => 'web'],
            ['name' => 'edit-post', 'guard_name' => 'web'],
            ['name' => 'delete-post', 'guard_name' => 'web'],
        ];

        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        foreach ($usersPermissions as $permission) {
            $p = Permission::firstOrCreate($permission);
            $p->assignRole($roleAdmin);
        }

        foreach ($postsPermissions as $permission) {
            $p = Permission::firstOrCreate($permission);
            $p->assignRole($roleUser);
        }

        /*
         * Super Admin
         */
        $superAdmin = User::firstOrCreate(['email' => 'super@admin.com'], [
            'name' => 'super admin',
            'email' => 'super@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_active' => 1
        ]);
        $superAdmin->syncRoles([$roleSuperAdmin->id]);

        /*
         * Admin
         */
        $admin = User::firstOrCreate(['email' => 'admin@admin.com'], [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_active' => 1
        ]);
        $admin->syncRoles([$roleAdmin->id]);

        /*
         * User
         */
        $user = User::firstOrCreate(['email' => 'user@user.com'], [
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_active' => 1
        ]);
        $user->syncRoles([$roleUser->id]);


        \App\Models\User::factory(100)->create()->each(function ($user) use ($roleUser) {
            $user->syncRoles([$roleUser->id]);
        });
        \App\Models\Post::factory(500)->create();

    }
}
