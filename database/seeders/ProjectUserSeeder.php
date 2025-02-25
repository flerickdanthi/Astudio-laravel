<?php

namespace Database\Seeders;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    public function run()
    {
        $userProjects = [
            [
                'user_id' => 1,  // John Doe
                'projects' => [1, 2],  // Assign John to Project A and Project B
                'created_at '=>'',
                'upadted_at '=>'',
            ],
            [
                'user_id' => 2,  // Jane Smith
                'projects' => [1],
                'created_at '=>'',
                'upadted_at '=>'',  // Assign Jane to Project A only
            ],
        ];

        foreach ($userProjects as $userProject) {
            $user = User::find($userProject['user_id']);
            $user->projects()->syncWithoutDetaching($userProject['projects']);  // Attach projects to the user
        }
    }
}
