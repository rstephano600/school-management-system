<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SubscriptionCategory;

class SubscriptionCategorySeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionCategory::create([
            'name' => 'Basic',
            'description' => 'For small schools up to 100 students',
            'max_students' => 100,
            'price' => 0.00
        ]);

        SubscriptionCategory::create([
            'name' => 'Standard',
            'description' => 'For schools up to 500 students',
            'max_students' => 500,
            'price' => 200000
        ]);

        SubscriptionCategory::create([
            'name' => 'Premium',
            'description' => 'Unlimited student support',
            'max_students' => 10000,
            'price' => 500000
        ]);
    }
}
