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
                'attribute_id' => 1,  // Assuming attribute_id 1 is "Department"
                'entity_id' => 1,  // Assuming entity_id 1 is Project A
                'value' => 'IT',
            ],
            [
                'attribute_id' => 2,  // Assuming attribute_id 2 is "Start Date"
                'entity_id' => 1,  // Assuming entity_id 1 is Project A
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
