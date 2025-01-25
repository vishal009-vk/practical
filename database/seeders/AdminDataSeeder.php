<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@gmail.com']);
        $admin->unique_id = Str::uuid();
        $admin->first_name = "Admin";
        $admin->last_name = "Admin";
        $admin->email = "admin@gmail.com";
        $admin->user_type = "Admin";
        $admin->password = Hash::make('12345678');
        $admin->save();
    }
}
