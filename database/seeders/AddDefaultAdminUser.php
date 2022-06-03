<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Http\Services\ModelService;

class AddDefaultAdminUser extends Seeder
{
    public function run()
    {
        $password = '$2a$12$mfRh37nTheVB1QaJ7kFDLOnXV5HnrbNQ5YjXUmnwA2B4mOU//4Pau'; //admin1
        ModelService::insert(User::class, [
            'username' => 'admin',
            'password' => $password,
            'fullname' => 'Administrator',
            'email' => 'saoxa37@gmail.com',
            'phone' => '0329012526',
            'verified' => 1,
            'reflink' => 'ADMINREF',
            'role' => 'admin'
        ]);
    }
}
