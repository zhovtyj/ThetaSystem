<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Create new User with name - Admin
        $admin = new User();
        $admin->name = 'Admin';
        $admin->password = bcrypt('12345');
        $admin->enabled = true;
        /**Get the ID of ROLE - Admin*/
        $role_admin = Role::where('name', 'Admin')->first();
        $admin->role_id = $role_admin->id;
        $admin->save();


        /**
         * Create new User with name - Agent
         */
        $agent = new User();
        $agent->name = 'Agent';
        $agent->password = bcrypt('12345');
        $agent->enabled = true;
        /**Get the ID of ROLE - Agent*/
        $role_agent = Role::where('name', 'Agent')->first();
        $agent->role_id = $role_agent->id;
        $agent->save();

    }
}
