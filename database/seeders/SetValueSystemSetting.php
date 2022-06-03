<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetValueSystemSetting extends Seeder
{
    public function __construct()
    {
        $this->db = DB::table('system_settings');
        $this->db_history = DB::table('history_system_setting');
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->insert('rate', '1');
        $this->insert('bonus', '50');
    }

    /**
     * @param $type
     * @param $value
     * @return void
     */
    private function insert($type, $value): void
    {
        if($this->db->where(['type' => $type])->first() != null){
            return;
        }
        $aryInsert = [
            'type' => $type,
            'value' => $value
        ];
        $this->db->insert($aryInsert);
        $this->db_history->insert($aryInsert);
    }
}
