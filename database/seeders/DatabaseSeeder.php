<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleHasPermissionSeeder::class,

            SuperAdminSeeder::class,
        
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // ]);

        $this->seedOwners();
        $this->seedCorners();
        $this->seedCities();
        $this->seedTownships();
        $this->seedWards();
        $this->seedStreets();
        $this->seedWifis();
        $this->seedLands();
        $this->seedRenters();
        $this->seedOwnerData();

    }

    private function seedOwners()
    {
        DB::table('owners')->insert($this->generateData('owners'));
    }

    private function seedCorners()
    {
        DB::table('corners')->insert($this->generateData('corners'));
    }

    private function seedCities()
    {
        DB::table('cities')->insert($this->generateData('cities'));
    }

    private function seedTownships()
    {
        DB::table('townships')->insert($this->generateData('townships'));
    }

    private function seedWards()
    {
        DB::table('wards')->insert($this->generateData('wards'));
    }

    private function seedStreets()
    {
        DB::table('streets')->insert($this->generateData('streets'));
    }

    private function seedWifis()
    {
        DB::table('wifis')->insert($this->generateData('wifis'));
    }

    private function seedLands()
    {
        DB::table('lands')->insert($this->generateData('lands'));
    }

    private function seedRenters()
    {
        DB::table('renters')->insert($this->generateData('lands'));
    }

    private function seedOwnerData()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('owner_data')->insert([
                'owner_id' => rand(1, 20),
                'corner_id' => rand(1, 20),
                'city_id' => rand(1, 20),
                'township_id' => rand(1, 20),
                'ward_id' => rand(1, 20),
                'street_id' => rand(1, 20),
                'wifi_id' => rand(1, 20),
                'land_no' => Str::random(5),
                'house_no' => Str::random(5),
                'property' => 'House',
                'meter_no' => 'MTR' . rand(1000, 9999),
                'meter_bill_code' => 'BILL' . rand(1000, 9999),
                'wifi_user_id' => 'USER' . rand(100, 999),
                'land_id' => rand(1, 20),
                'issuance_date' => now()->subDays(rand(30, 365))->format('Y-m-d'),
                'expired' => now()->addDays(rand(30, 365))->format('Y-m-d'),
                'renter_id' => rand(1, 20),
                'contract_date' => now()->subMonths(rand(1, 12)),
                'end_of_contract_date' => now()->addMonths(rand(1, 12)),
                'price_per_month' => rand(100, 1000) . ' USD',
                'total_months' => rand(1, 12),
                'notes' => 'This is a sample note.',
                'photos' => json_encode(["photo1.jpg", "photo2.jpg"]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateData($table)
    {
        return array_map(fn () => [
            'name' => ucfirst($table) . ' ' . Str::random(5),
            'created_at' => now(),
            'updated_at' => now(),
        ], range(1, 20));
    }
}
