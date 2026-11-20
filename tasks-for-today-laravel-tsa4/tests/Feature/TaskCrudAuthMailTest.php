<?php

namespace Tests\Feature;

use App\Mail\TaskCompletedMail;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TaskCrudAuthMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible_to_guests(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')->assertOk();
        $this->get('/tasks')->assertOk();
        $this->get('/profile')->assertOk();
        $this->get('/about')->assertOk();
    }

    public function test_guests_cannot_access_task_management_actions(): void
    {
        $this->seed(DatabaseSeeder::class);
        $task = Task::firstOrFail();

        $this->get('/tasks/create')->assertRedirect('/login');
        $this->post('/tasks', [
            'title' => 'Unauthorized Task',
            'status' => Task::STATUS_PENDING,
            'task_date' => Carbon::today()->toDateString(),
        ])->assertRedirect('/login');
        $this->get("/tasks/{$task->id}/edit")->assertRedirect('/login');
        $this->put("/tasks/{$task->id}", [
            'title' => 'Edited Unauthorized',
            'status' => Task::STATUS_DONE,
            'task_date' => Carbon::today()->toDateString(),
        ])->assertRedirect('/login');
        $this->delete("/tasks/{$task->id}")->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_task_and_validation_rejects_bad_input(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::firstOrFail();

        // Invalid submission fails validation
        $this->actingAs($user)
            ->post('/tasks', [
                'title' => '',
                'status' => 'invalid_status',
                'task_date' => 'not-a-date',
            ])
            ->assertSessionHasErrors(['title', 'status', 'task_date']);

        // Valid submission creates task
        $this->actingAs($user)
            ->post('/tasks', [
                'title' => 'Complete TSA4 PHPUnit verification',
                'status' => Task::STATUS_PENDING,
                'task_date' => Carbon::today()->toDateString(),
            ])
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'Complete TSA4 PHPUnit verification',
            'status' => Task::STATUS_PENDING,
            'is_archived' => false,
        ]);
    }

    public function test_marking_pending_task_as_done_sends_email_once_and_does_not_resend(): void
    {
        Mail::fake();
        $this->seed(DatabaseSeeder::class);
        $user = User::firstOrFail();

        $task = Task::create([
            'title' => 'Pending task to complete',
            'status' => Task::STATUS_PENDING,
            'task_date' => Carbon::today()->toDateString(),
            'is_archived' => false,
        ]);

        // 1. Transition pending -> done: email SHOULD be sent once
        $this->actingAs($user)
            ->put(route('tasks.update', $task), [
                'title' => 'Pending task to complete',
                'status' => Task::STATUS_DONE,
                'task_date' => Carbon::today()->toDateString(),
            ])
            ->assertRedirect(route('tasks.index'));

        Mail::assertSent(TaskCompletedMail::class, 1);

        // 2. Updating an already-done task: email MUST NOT be resent
        Mail::fake();

        $this->actingAs($user)
            ->put(route('tasks.update', $task), [
                'title' => 'Already done task edited title',
                'status' => Task::STATUS_DONE,
                'task_date' => Carbon::today()->toDateString(),
            ])
            ->assertRedirect(route('tasks.index'));

        Mail::assertNothingSent();
    }

    public function test_authenticated_user_can_soft_delete_task_using_is_archived(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::firstOrFail();
        $task = Task::forToday()->firstOrFail();

        $this->actingAs($user)
            ->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_archived' => true,
        ]);

        $this->get('/')->assertDontSee($task->title);
        $this->get('/tasks')->assertDontSee($task->title);
    }

    public function test_breeze_login_and_logout_flow(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->post('/login', [
            'email' => 'jpenarroyo53@gmail.com',
            'password' => 'password',
        ])->assertRedirect(route('tasks.index'));

        $this->assertAuthenticated();

        $this->post('/logout')->assertRedirect(route('welcome'));
        $this->assertGuest();
    }
}
