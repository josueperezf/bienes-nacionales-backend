<?php

use Illuminate\Database\Seeder;

class TipoMovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1','nombre' => 'INCORPORACION'],
            ['id' => '2','nombre' => 'REASIGNACION'],
            ['id' => '3','nombre' => 'DESINCORPORACION']
        ];
        App\TipoMovimiento::insert($data);
    }
}
