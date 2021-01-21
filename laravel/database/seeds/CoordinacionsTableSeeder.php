<?php

use Illuminate\Database\Seeder;

class CoordinacionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Coordinacion::create([
            'nombre'     => 'DESINCORPORACION',
        ]);
        App\Coordinacion::create([
            'nombre'     => 'TACHIRA',
        ]);
        App\Subcoordinacion::create([
            'coordinacion_id'=>1,
            'ciudad'     => 'DESINCORPORACION',
            'nombre'     => 'DESINCORPORACION',
            'direccion'     => 'DESINCORPORACION',
        ]);
        App\UnidadAdministrativa::create([
            'subcoordinacion_id'=>1,
            'nombre'     => 'DESINCORPORACION',
            'telefono'     => '0000-0000000',
        ]);
        App\DependenciaUsuaria::create([
            'tipo_dependencia_usuaria_id'=>3,
            'unidad_administrativa_id'=>1,
            'nombre'     => 'DESINCORPORACION',
        ]);
    }
}
