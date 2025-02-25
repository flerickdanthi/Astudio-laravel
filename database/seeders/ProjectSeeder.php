<?php

namespace Database\Seeders;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'name' => 'Project A',
                'status' => 'active',
            ],
            [
                'name' => 'Project B',
                'status' => 'inactive',
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['name' => $project['name']],  // Check if a project with this name exists
                $project  // Use the data to create or update
            );
        }
    }
}
