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
            'Primera Licencia',
            'Renovacion Licencia',
            'Ampliacion Licencia',
            'Control',
            'Licencia clase B',
            'Licencia clase A1',
            'Licencia clase A2',
            'Licencia clase C',
            'Licencia clase D',
            'Licencia clase E',
            'Licencia clase F',
        ];

        foreach ($atencion as $tipo) {
            Tipo::create([
                'nombre' => $tipo,
            ]);
        }
    }
}
