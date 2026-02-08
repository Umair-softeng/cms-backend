<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 20) as $i) {
            $branchID = $faker->randomNumber(1, 17);
            $userID = \App\Models\User::where('branchID', $branchID)
                ->inRandomOrder()
                ->value('id');
            DB::table('complaints')->insert([
                'trackingID' => Helpers::genrateTrackingID(),
                'name' => $faker->name,
                'cnic' => $faker->numerify('#####-#######-#'),
                'mobileNo' => $faker->numerify('####-#######'),
                'title' => $faker->text(),
                'status' => $faker->randomElement(['New', 'In-Progress', 'Resolved', 'Dropped']),
                'priority' => $faker->randomElement(['Normal', 'Escalated', 'Super Escalated']),
                'complaint' => $faker->sentence(),
                'location' => $faker->address(),
                'remarks' => null,
                'branchID' => $branchID,
                'userID' => $userID,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
