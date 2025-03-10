<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            [
                'name' => 'Department',
                'type' => 'select',
            ],
            [
                'name' => 'Start Date',
                'type' => 'date',
            ],
        ];

        foreach ($attributes as $attribute) {
            Attribute::updateOrCreate(
                ['name' => $attribute['name']],  
                $attribute 
            );
        }
    }
}
