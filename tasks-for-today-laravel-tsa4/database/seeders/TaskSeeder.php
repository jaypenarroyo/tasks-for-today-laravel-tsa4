<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Seed realistic tasks spanning multiple dates, including today.
     */
    public function run(): void
    {
        Task::query()->delete();

        $yesterday = Carbon::yesterday()->toDateString();
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();
        $nextWeek = Carbon::today()->addDays(3)->toDateString();

        $tasks = [
            // Yesterday (2 tasks)
            [
                'title' => 'Configure Laravel Breeze authentication and middleware protection',
                'status' => Task::STATUS_DONE,
                'task_date' => $yesterday,
                'is_archived' => false,
            ],
            [
                'title' => 'Add is_archived column to tasks migration for soft deletion',
                'status' => Task::STATUS_DONE,
                'task_date' => $yesterday,
                'is_archived' => false,
            ],

            // Today (4 tasks — displayed on the Welcome page "/")
            [
                'title' => 'Verify TaskCompletedMail triggers when a pending task is marked done',
                'status' => Task::STATUS_PENDING,
                'task_date' => $today,
                'is_archived' => false,
            ],
            [
                'title' => 'Confirm editing an already-done task does not resend notification email',
                'status' => Task::STATUS_DONE,
                'task_date' => $today,
                'is_archived' => false,
            ],
            [
                'title' => 'Test Create, Edit, and Soft-Delete (Archive) flows while logged in',
                'status' => Task::STATUS_IN_PROGRESS,
                'task_date' => $today,
                'is_archived' => false,
            ],
            [
                'title' => 'Confirm guests can view public pages but cannot modify tasks',
                'status' => Task::STATUS_PENDING,
                'task_date' => $today,
                'is_archived' => false,
            ],

            // Tomorrow (2 tasks)
            [
                'title' => 'Run PHPUnit feature tests for CRUD, Auth, Validation, and Mail',
                'status' => Task::STATUS_PENDING,
                'task_date' => $tomorrow,
                'is_archived' => false,
            ],
            [
                'title' => 'Review README.md setup and mail configuration documentation',
                'status' => Task::STATUS_PENDING,
                'task_date' => $tomorrow,
                'is_archived' => false,
            ],

            // 3 days ahead (2 tasks)
            [
                'title' => 'Deploy TSA4 Laravel application and test live hosted URL',
                'status' => Task::STATUS_PENDING,
                'task_date' => $nextWeek,
                'is_archived' => false,
            ],
            [
                'title' => 'Submit GitHub repository and live application link for IT0049 TSA4',
                'status' => Task::STATUS_PENDING,
                'task_date' => $nextWeek,
                'is_archived' => false,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
