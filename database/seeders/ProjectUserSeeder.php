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
                'user_id' => 1,  
                'projects' => [1, 2],  
                'created_at '=>'',
                'upadted_at '=>'',
            ],
            [
                'user_id' => 2,  
                'projects' => [1],
                'created_at '=>'',
                'upadted_at '=>'',
            ],
        ];

        foreach ($userProjects as $userProject) {
            $user = User::find($userProject['user_id']);
            $user->projects()->syncWithoutDetaching($userProject['projects']);  // Attach projects to the user
        }
    }
}
