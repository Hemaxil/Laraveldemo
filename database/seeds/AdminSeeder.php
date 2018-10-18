<?php

use Illuminate\Database\Seeder;
use App\Admin as Admin;
use App\User as User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$password=Hash::make('admin123');
        $admin=User::create(['firstname'=>'Admin','lastname'=>'admin','email'=>'hemaxilade@gmail.com','password'=>$password,'status'=>1]);
            
        $admin->assignRole('superadmin');
    }
}
