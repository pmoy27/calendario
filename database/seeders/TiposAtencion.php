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
            'Atención de Licencia clase B',
            'Atención de Licencia clase A1',
            'Atención de Licencia clase A2',
            'Atención de Licencia clase C',
            'Atención de Licencia clase D',
            'Atención de Licencia clase E',
            'Atención de Licencia clase F',
        ];

        foreach ($atencion as $tipo) {
            Tipo::create([
                'nombre' => $tipo,
            ]);
        }
    }
}
