<?php

use Illuminate\Database\Seeder;

class DetalleTipoMovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1','tipo_movimiento_id' => '1','codigo' => '01','nombre' => 'Compras'],
            ['id' => '2','tipo_movimiento_id' => '1','codigo' => '02','nombre' => 'Inventario'],
            ['id' => '3','tipo_movimiento_id' => '1','codigo' => '03','nombre' => 'Fabricación o producción de materiales bienes'],
            ['id' => '4','tipo_movimiento_id' => '1','codigo' => '04','nombre' => 'Omisión en inventario inicial'],
            ['id' => '5','tipo_movimiento_id' => '1','codigo' => '05','nombre' => 'Ingreso provisional de bienes materiales proveniente de programas especiales'],
            ['id' => '6','tipo_movimiento_id' => '1','codigo' => '06','nombre' => 'Ingreso definitivo de bienes y materiales proveniente de programas especiales'],
            ['id' => '7','tipo_movimiento_id' => '1','codigo' => '07','nombre' => 'Devolución y materiales robados, hurtados o perdidos'],
            ['id' => '8','tipo_movimiento_id' => '1','codigo' => '08','nombre' => 'Aparición de bienes y materiales desincorporados por causas imputables a funcionarios o empleados'],
            ['id' => '9','tipo_movimiento_id' => '1','codigo' => '11','nombre' => 'Donaciones'],
            ['id' => '10','tipo_movimiento_id' => '1','codigo' => '12','nombre' => 'Permuta'],
            ['id' => '11','tipo_movimiento_id' => '1','codigo' => '13','nombre' => 'Ingreso provisional de bienes dados en comodato'],
            ['id' => '12','tipo_movimiento_id' => '1','codigo' => '14','nombre' => 'Ingreso definitivo de bienes dados en comodato'],
            ['id' => '13','tipo_movimiento_id' => '1','codigo' => '15','nombre' => 'Herencia vacantes'],
            ['id' => '14','tipo_movimiento_id' => '1','codigo' => '16','nombre' => 'Decomiso de bienes y materiales'],
            ['id' => '15','tipo_movimiento_id' => '1','codigo' => '17','nombre' => 'Ingreso provisional de bienes y materiales bajo guarda judicial'],
            ['id' => '16','tipo_movimiento_id' => '1','codigo' => '18','nombre' => 'Ingreso definitivo de bienes y materiales que habían sido registrados provisionalmente bajo guarda judicial'],
            ['id' => '17','tipo_movimiento_id' => '1','codigo' => '19','nombre' => 'Incorporación por otros conceptos '],
            ['id' => '18','tipo_movimiento_id' => '2','codigo' => '20','nombre' => 'Recepción de bienes o materiales procedentes de almacén de la administración central'],
            ['id' => '19','tipo_movimiento_id' => '2','codigo' => '21','nombre' => 'Recepción de bienes o materiales de otras dependencias del organismo ordenador de compromisos y pagos '],
            ['id' => '20','tipo_movimiento_id' => '2','codigo' => '22','nombre' => 'Recepción de bienes o materiales de otros organismos ordenadores de compromisos y pagos'],
            ['id' => '21','tipo_movimiento_id' => '2','codigo' => '23','nombre' => 'Recepción de bienes o materiales procedentes de otros organismos de las administración publica'],
            ['id' => '22','tipo_movimiento_id' => '2','codigo' => '24','nombre' => 'Devolución de bienes prestados a contratistas'],
            ['id' => '23','tipo_movimiento_id' => '2','codigo' => '25','nombre' => 'Incorporación por cambio de grupo,cuentay subcuenta'],
            ['id' => '24','tipo_movimiento_id' => '2','codigo' => '26','nombre' => 'Correcciones de desincorporaciones '],
            ['id' => '25','tipo_movimiento_id' => '2','codigo' => '27','nombre' => 'Otros cargos por resignaciones'],
            ['id' => '26','tipo_movimiento_id' => '2','codigo' => '30','nombre' => 'Entrega de bienes o materiales por parte de almacén'],
            ['id' => '27','tipo_movimiento_id' => '2','codigo' => '31','nombre' => 'Entrega de bienes o materiales a otras dependencias del organismo ordenador de compromisos y pagos'],
            ['id' => '28','tipo_movimiento_id' => '2','codigo' => '32','nombre' => 'Entrega de bienes o materiales a otros organismos ordenadores de compromisos y pagos'],
            ['id' => '29','tipo_movimiento_id' => '2','codigo' => '33','nombre' => 'Entrega de bienes o materiales a otros organismos ordenadores de la Administración Publica Nacional'],
            ['id' => '30','tipo_movimiento_id' => '2','codigo' => '34','nombre' => 'Préstamo de bienes contratistas'],
            ['id' => '31','tipo_movimiento_id' => '2','codigo' => '35','nombre' => 'Desincorporacion por cambio de grupo, cuenta o subcuenta'],
            ['id' => '32','tipo_movimiento_id' => '2','codigo' => '36','nombre' => 'Correcciones de incorporaciones'],
            ['id' => '33','tipo_movimiento_id' => '2','codigo' => '37','nombre' => 'Ajustes por cambio del método de depreciación'],
            ['id' => '34','tipo_movimiento_id' => '2','codigo' => '39','nombre' => 'Otros descargos por reasignaciones '],
            ['id' => '35','tipo_movimiento_id' => '3','codigo' => '40','nombre' => 'Error de incorporación de bienes o materiales'],
            ['id' => '36','tipo_movimiento_id' => '3','codigo' => '41','nombre' => 'Pase a situación de desuso para reasignacion, venta o disposición final'],
            ['id' => '37','tipo_movimiento_id' => '3','codigo' => '42','nombre' => 'Bienes o materiales en custodia en el almacén '],
            ['id' => '38','tipo_movimiento_id' => '3','codigo' => '43','nombre' => 'Venta'],
            ['id' => '39','tipo_movimiento_id' => '3','codigo' => '44','nombre' => 'Cesiones sin cargos a organismos del sector privado.'],
            ['id' => '40','tipo_movimiento_id' => '3','codigo' => '45','nombre' => 'Cesiones sin cargos a los entes descentralizados territorialmente '],
            ['id' => '41','tipo_movimiento_id' => '3','codigo' => '46','nombre' => 'Perdida de bienes con formulación de cargos'],
            ['id' => '42','tipo_movimiento_id' => '3','codigo' => '47','nombre' => 'Robo o hurto de bienes o materiales'],
            ['id' => '43','tipo_movimiento_id' => '3','codigo' => '48','nombre' => 'Otras perdidas de bienes o materiales no culposas '],
            ['id' => '44','tipo_movimiento_id' => '3','codigo' => '49','nombre' => 'Destrucción o incineración de bienes o materiales'],
            ['id' => '45','tipo_movimiento_id' => '3','codigo' => '50','nombre' => 'Desarme o desmantelamiento de bienes'],
            ['id' => '46','tipo_movimiento_id' => '3','codigo' => '51','nombre' => 'Inservibilidad '],
            ['id' => '47','tipo_movimiento_id' => '3','codigo' => '52','nombre' => 'Deterioro'],
            ['id' => '48','tipo_movimiento_id' => '3','codigo' => '53','nombre' => 'Demolición'],
            ['id' => '49','tipo_movimiento_id' => '3','codigo' => '57','nombre' => 'Desincorporacion por permuta '],
            ['id' => '50','tipo_movimiento_id' => '3','codigo' => '58','nombre' => 'Desincorporacion por por donación '],
            ['id' => '51','tipo_movimiento_id' => '3','codigo' => '59','nombre' => 'Desincorporacion por otros conceptos ']
        ];
        App\DetalleTipoMovimiento::insert($data);
    }
}
