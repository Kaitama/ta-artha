<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $golongans = [
            ['name' => 'III/a'],
            ['name' => 'III/b'],
            ['name' => 'III/c'],
            ['name' => 'III/d'],
            ['name' => 'IV/a'],
            ['name' => 'IV/b'],
            ['name' => 'IV/c'],
            ['name' => 'IV/d'],
            ['name' => 'IV/e'],
        ];

        DB::table('golongans')->insert($golongans);

        // clone teachers
//        $gurus = User::has('roles', fn ($role) => $role->where('name', 'guru-tetap')->orWhere('name', 'guru-honor'))->get();
        $gurus = User::role(['guru-tetap', 'guru-honor'])->get();
        foreach ($gurus as $g) {
            Teacher::create([
                'user_id' => $g->id,
                'golongan_id' => rand(1, 9),
                'name' => $g->name,
                'phone'=> $g->phone,
                'birthplace' => $g->birthplace,
                'birthdate' => $g->birthdate,
                'education' => $g->education,
                'major' => $g->major,
                'university' => $g->university,
            ]);
        }
    }
}
