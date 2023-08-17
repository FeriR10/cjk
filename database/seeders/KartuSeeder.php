<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kartu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KartuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Kartu::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['nama' => 'telkomsel' ],
            ['nama' => 'indosat' ],
            ['nama' => 'three' ],
        ];
    
        foreach ($data as $value)
            {
                Kartu::insert([
                    'nama' => $value['nama'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
    }
}
