<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class PesertaSeeder extends Seeder
{
    public function run(): void {
        $role = Role::where('nama_role', 'peserta')->firstOrFail();

        User::firstOrCreate(
            ['email' => 'peserta@test.com'],
            [
                'role_id' => $role->id,
                'nama' => 'peserta tes',
                'password' => Hash::make('Peserta123!'),
            ]
        );
    }
}
