<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipoDeuda')->insert([
            ['nombreTipoDeuda' => 'Deuda'],
            ['nombreTipoDeuda' => 'Deudor'],
        ]);

        DB::table('tipoMovimiento')->insert([
            ['nombreTipoMovimiento' => 'Ingreso'],
            ['nombreTipoMovimiento' => 'Egreso'],
        ]);
    }
}
