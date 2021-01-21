<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoDependenciaUsuariasTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(DenominacionsTableSeeder::class);
        $this->call(TipoMovimientosTableSeeder::class);
        $this->call(DetalleTipoMovimientosTableSeeder::class);
        $this->call(CoordinacionsTableSeeder::class);
    }
}
