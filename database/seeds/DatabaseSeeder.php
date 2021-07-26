<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            $this->call('PermissionsTableSeeder');
            $this->call('RolesTableSeeder');
            $this->call('ConnectRelationshipsSeeder');

            $this->call('UsersTableSeeder');

            $this->call('ExamTypesTableSeeder');
            $this->call('PatientsTableSeeder');
            $this->call('ShieldsTableSeeder');
            $this->call('SensorsTableSeeder');
            $this->call('ExamsTableSeeder');

        Model::reguard();
    }
}
