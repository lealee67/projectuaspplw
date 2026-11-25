<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PanitiaSeeder extends Seeder
{
    public function run(): void
    {
        $role = DB::table('roles')
            ->where('nama_role', 'panitia')
            ->first();

        User::create([
            'role_id' => $role->id,
            'nama' => 'Admin ArChamp',
            'email' => 'panitia@archamp.test',
            'password' => 'Panitia123!',
        ]);
    }
}
