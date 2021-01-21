<?php

use Illuminate\Database\Seeder;

class TipoDependenciaUsuariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['nombre'     => 'ALMACEN'],
            ['nombre'     => 'DEPARTAMENTO'],
            ['nombre'     => 'DESINCORPORACION'],
        ];
        App\TipoDependenciaUsuaria::insert($data);
    }
}
