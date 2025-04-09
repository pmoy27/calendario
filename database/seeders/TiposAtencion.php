<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposAtencion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $atencion = [

            'Primera Licencia (2)',


            'Control (2)',

        ];

        foreach ($atencion as $tipo) {
            Tipo::create([
                'nombre' => $tipo,
            ]);
        }
    }
}
