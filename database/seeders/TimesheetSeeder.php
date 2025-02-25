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
                'user_id' => 1,  // Assuming user_id 1 is John Doe
                'project_id' => 1,  // Assuming project_id 1 is Project A
            ],
            [
                'task_name' => 'Task 2',
                'date' => '2025-02-25',
                'hours' => 6,
                'user_id' => 2,  // Assuming user_id 2 is Jane Smith
                'project_id' => 2,  // Assuming project_id 2 is Project B
            ],
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::updateOrCreate(
                ['task_name' => $timesheet['task_name'], 'date' => $timesheet['date']],  // Unique condition
                $timesheet  // Use the data to create or update
            );
        }
    }
}
