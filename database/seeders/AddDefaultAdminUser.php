<?php

namespace Database\Seeders;

use App\Exceptions\UserException;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Http\Services\ModelService;

class AddDefaultAdminUser extends Seeder
{
    /**
     * @throws UserException
     */
    public function run()
    {
        if (User::getUserByUsername('admin', true) != null) {
            return;
        }
        $password = '$2a$12$mfRh37nTheVB1QaJ7kFDLOnXV5HnrbNQ5YjXUmnwA2B4mOU//4Pau'; //admin1
        ModelService::insert(User::class, [
            'username' => 'admin',
            'password' => $password,
            'fullname' => 'Administrator',
            'email' => 'administator@aidigitalmedia.co',
            'phone' => '0123456789',
            'verified' => 1,
            'reflink' => 'ADMINREF',
            'role' => 'admin'
        ]);
    }
}
