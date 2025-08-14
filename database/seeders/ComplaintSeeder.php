<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Complaint::create([
            'resident_id' => '1',
            'title' => 'Sampah Menumpuk',
            'content' => 'Halo Pak, sampah menumpuk nih',
        ]);
    }
}
