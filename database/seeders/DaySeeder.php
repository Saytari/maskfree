<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Day::create([
            'name' => 'السبت'
        ]);
        
        \App\Models\Day::create([
            'name' => 'الأحد'
        ]);

        \App\Models\Day::create([
            'name' => 'الإثنين'
        ]);

        \App\Models\Day::create([
            'name' => 'الثلاثاء'
        ]);

        \App\Models\Day::create([
            'name' => 'الاربعاء'
        ]);

        \App\Models\Day::create([
            'name' => 'الخميس'
        ]);

        \App\Models\Day::create([
            'name' => 'الجمعة'
        ]);
    }
}
