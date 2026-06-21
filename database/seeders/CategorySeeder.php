<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        $defaults = [
            ['name' => 'Salary',      'type' => 'income',  'color' => '#28a745'],
            ['name' => 'Freelance',   'type' => 'income',  'color' => '#20c997'],
            ['name' => 'Other Income','type' => 'income',  'color' => '#17a2b8'],
            ['name' => 'Food',        'type' => 'expense', 'color' => '#fd7e14'],
            ['name' => 'Fuel',        'type' => 'expense', 'color' => '#dc3545'],
            ['name' => 'Transport',   'type' => 'expense', 'color' => '#e83e8c'],
            ['name' => 'Utilities',   'type' => 'expense', 'color' => '#6f42c1'],
            ['name' => 'Healthcare',  'type' => 'expense', 'color' => '#007bff'],
            ['name' => 'Entertainment','type'=> 'expense', 'color' => '#ffc107'],
            ['name' => 'Other',       'type' => 'expense', 'color' => '#6c757d'],
        ];

        foreach ($defaults as $cat) {
            Category::firstOrCreate(
                ['user_id' => $user->id, 'name' => $cat['name'], 'type' => $cat['type']],
                ['color' => $cat['color']]
            );
        }
    }
}
