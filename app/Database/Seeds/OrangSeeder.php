<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Bae Suzy',
                'alamat'    => 'Jl. Seoul Raya No. 123',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama' => 'Lee Sung Kyung',
                'alamat'    => 'Jl. Seoul Raya No. 232',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama' => 'Joy',
                'alamat'    => 'Jl. Seoul Raya No. 232',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ]
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)', $data);

        // Using Query Builder
        // $this->db->table('orang')->insert($data);
        $this->db->table('orang')->insertBatch($data);
    }
}
