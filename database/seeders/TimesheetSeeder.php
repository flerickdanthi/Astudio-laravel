<?php

namespace Database\Seeders;
use App\Models\Timesheet;
use Illuminate\Database\Seeder;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        $timesheets = [
            [
                'task_name' => 'Task 1',
                'date' => '2025-02-24',
                'hours' => 8,
                'user_id' => 1,  
                'project_id' => 1, 
            ],
            [
                'task_name' => 'Task 2',
                'date' => '2025-02-25',
                'hours' => 6,
                'user_id' => 2,  
                'project_id' => 2, 
            ],
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::updateOrCreate(
                ['task_name' => $timesheet['task_name'], 'date' => $timesheet['date']],  // Unique condition
                $timesheet  
            );
        }
    }
}
