<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddDefaultAdminUser extends Seeder
{
    public function run()
    {
        $password = '$2y$10$p.8dVjdcNmKRkCFi0Jl6EuwL/oVDSe.cgEQJCo3WE8pi5M5dQLm9y';
        DB::statement("INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `phone`, `phone_telegram`, `login_fail`, `password_old`, `otp_key`, `otp_public_key`, `verified`, `remember_token`, `is_delete`, `created_at`, `updated_at`, `reflink`, `role`, `upline_by`, `money_invest`, `invest_no_bonus`, `money_wallet`, `bonus_received_type1`, `bonus_received_type2`, `level`, `rate_ib`, `super_parent`, `money_ib`, `ref_is_admin`, `addr_crypto`) VALUES (NULL, 'admin', '$password', 'Administrator', 'Saoxa37@gmail.com', '0329012526', '0329012526', '0', '[\"admin1\"]', '049074', 'BrwSUAcw8hb8eg9L7vAjk1rw', '1', '', '0', '2021-08-01 22:19:26', '2021-08-22 10:42:38', 'zBIHTORK', 'admin', '', '400', '0', '', '0', '1', '0', '0', '[\"zBIHTORK\"]', '0', '0', '')");
    }
}
