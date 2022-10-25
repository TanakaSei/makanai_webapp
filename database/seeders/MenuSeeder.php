<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CSV読み込み
        $memberSplFileObject = new \SplFileObject(__DIR__ . '/data/MenuSeed.csv');
        $memberSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        
        foreach ($memberSplFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            DB::table('menus')->insert([
                'menuName' => trim($row[0]),
                'categoryNumber' => trim($row[1]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
