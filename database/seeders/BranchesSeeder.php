<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{

    public function run(): void
    {
        $branches = [
            ['name_en' => 'Electric ', 'name_ur' => '(الیکٹرک )'],
            ['name_en' => 'Record ', 'name_ur' => '(ریکارڈ )'],
            ['name_en' => 'Fire Brigade ', 'name_ur' => '(فائر بریگیڈ )'],
            ['name_en' => 'Anti-Encroachment ', 'name_ur' => '(انسداد تجاوزات )'],
            ['name_en' => 'Building ', 'name_ur' => '(بلڈنگ )'],
            ['name_en' => 'Transport ', 'name_ur' => '(ٹرانسپورٹ )'],
            ['name_en' => 'Sanitation ', 'name_ur' => '(سینیٹیشن )'],
            ['name_en' => 'Taxation ', 'name_ur' => '(ٹیکسیشن )'],
            ['name_en' => 'Health ', 'name_ur' => '(ہیلتھ )'],
            ['name_en' => 'Admin ', 'name_ur' => '(انتظامیہ )'],
            ['name_en' => 'MT ', 'name_ur' => '(میکینیکل ٹرانسپورٹ )'],
            ['name_en' => 'Account ', 'name_ur' => '(اکاؤنٹس )'],
            ['name_en' => 'Engineering ', 'name_ur' => '(انجینئرنگ )'],
            ['name_en' => 'Veterinary ', 'name_ur' => '(ویٹرنری )'],
            ['name_en' => 'Complaint Cell', 'name_ur' => '(شکایات سیل )'],
            ['name_en' => 'MCQ Schools', 'name_ur' => '(ایم سی کیو اسکولز)'],
            ['name_en' => 'Library ', 'name_ur' => '(لائبریری )'],
            ['name_en' => 'Law ', 'name_ur' => '(قانون )']
        ];

        foreach ($branches as $branch){
            DB::table('branches')->insert(['name_en' => $branch['name_en'], 'name_ur' => $branch['name_ur']]);
        }
    }
}
