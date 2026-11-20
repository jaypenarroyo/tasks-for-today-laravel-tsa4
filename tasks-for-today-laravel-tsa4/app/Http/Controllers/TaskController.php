<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Mail\TaskCompletedMail;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Public Welcome page: displays only today's active (non-archived) tasks.
     */
    public function welcome(): View
    {
        $today = Carbon::today();
        $todayTasks = Task::forToday()
            ->orderBy('id', 'asc')
            ->get();

        $stats = [
            'total' => $todayTasks->count(),
            'pending' => $todayTasks->where('status', Task::STATUS_PENDING)->count(),
            'in_progress' => $todayTasks->where('status', Task::STATUS_IN_PROGRESS)->count(),
            'done' => $todayTasks->where('status', Task::STATUS_DONE)->count(),
        ];

        return view('welcome', [
            'todayDate' => $today,
            'todayTasks' => $todayTasks,
            'stats' => $stats,
        ]);
    }

    /**
     * Public Task List page: displays all active (non-archived) tasks ordered by date.
     */
    public function index(): View
    {
        $tasks = Task::active()->orderedByDate()->get();
        $today = Carbon::today();

        $stats = [
            'total' => $tasks->count(),
            'today' => $tasks->filter(fn (Task $task) => $task->task_date->isSameDay($today))->count(),
            'pending' => $tasks->where('status', Task::STATUS_PENDING)->count(),
            'done' => $tasks->where('status', Task::STATUS_DONE)->count(),
            'archived' => Task::archived()->count(),
        ];

        return view('tasks.index', [
            'tasks' => $tasks,
            'today' => $today,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the Create Task form (authenticated users only).
     */
    public function create(): View
    {
        return view('tasks.create', [
            'defaultDate' => Carbon::today()->toDateString(),
            'statuses' => Task::STATUSES,
        ]);
    }

    /**
     * Store a newly created task in storage (authenticated users only).
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = Task::create([
            ...$request->validated(),
            'is_archived' => false,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('status', sprintf('Task "%s" has been created.', $task->title));
    }

    /**
     * Show the Edit Task form (authenticated users only).
     */
    public function edit(Task $task): View
    {
        abort_if($task->is_archived, 404);

        return view('tasks.edit', [
            'task' => $task,
            'statuses' => Task::STATUSES,
        ]);
    }

    /**
     * Update the specified task and send an email if status transitions to "done".
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        abort_if($task->is_archived, 404);

        $wasAlreadyDone = $task->status === Task::STATUS_DONE;

        $task->update($request->validated());

        $message = sprintf('Task "%s" has been updated.', $task->title);

        if (! $wasAlreadyDone && $task->status === Task::STATUS_DONE) {
            $recipient = config('mail.task_notification_recipient');

            if ($recipient) {
                Mail::to($recipient)->send(new TaskCompletedMail($task));
                $message = sprintf(
                    'Task "%s" marked as done. Notification email sent to %s.',
                    $task->title,
                    $recipient
                );
            }
        }

        return redirect()
            ->route('tasks.index')
            ->with('status', $message);
    }

    /**
     * Soft-delete a task by setting is_archived = true (authenticated users only).
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->update(['is_archived' => true]);

        return redirect()
            ->route('tasks.index')
            ->with('status', sprintf('Task "%s" has been archived.', $task->title));
    }
}
