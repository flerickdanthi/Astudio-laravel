<?php
namespace Database\Seeders;

use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run()
    {
        $attributeValues = [
            [
                'attribute_id' => 1,  
                'entity_id' => 1, 
                'value' => 'IT',
            ],
            [
                'attribute_id' => 2,  
                'entity_id' => 1, 
                'value' => '2025-02-01',
            ],
        ];

        foreach ($attributeValues as $attributeValue) {
            AttributeValue::updateOrCreate(
                ['attribute_id' => $attributeValue['attribute_id'], 'entity_id' => $attributeValue['entity_id']],  // Unique condition
                $attributeValue  // Use the data to create or update
            );
        }
    }
}
