<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('name', '=', 'Orvos')->first();
        $adminRole = Role::where('name', '=', 'Admin')->first();
        $permissions = Permission::all();

        /*
         * Add Users
         *
         */
        if (User::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = User::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        // if (User::where('email', '=', 'doctor@user.com')->first() === null) {
        //     $newUser = User::create([
        //         'name'     => 'Doctor User',
        //         'email'    => 'doctor@user.com',
        //         'password' => bcrypt('password'),
        //     ]);
        //
        //     $newUser;
        //     $newUser->attachRole($userRole);
        // }

        for ($i=1;$i<6;$i++) {
            $newUser = User::create([
                'name'     => 'Doctor User'.$i,
                'email'    => 'doctor'.$i.'@user.com',
                'password' => bcrypt('password'),
            ]);


            $newUser->attachRole($userRole);
        }
    }
}
