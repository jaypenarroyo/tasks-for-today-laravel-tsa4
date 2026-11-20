@extends('layouts.app')

@section('title', "Today's Tasks")

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Welcome</p>
            <h1 class="page-title">Tasks for Today</h1>
            <p class="page-subtitle">
                Showing active tasks scheduled for {{ $todayDate->format('l, F j, Y') }}.
            </p>
        </div>
        <div class="header-actions">
            @auth
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
            @endauth
            <a href="{{ route('tasks.index') }}" class="btn btn-outline">View All Tasks</a>
        </div>
    </div>

    <section class="stats-grid" aria-label="Today's Task Summary">
        <div class="stat-card">
            <p class="stat-label">Scheduled Today</p>
            <p class="stat-value">{{ $stats['total'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Pending</p>
            <p class="stat-value">{{ $stats['pending'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">In Progress</p>
            <p class="stat-value">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Done</p>
            <p class="stat-value">{{ $stats['done'] }}</p>
        </div>
    </section>

    <section class="card">
        <div class="card-header">
            <h2 class="card-title">Today's Agenda ({{ $todayDate->toDateString() }})</h2>
            <span class="task-meta">
                {{ $stats['total'] }} {{ \Illuminate\Support\Str::plural('task', $stats['total']) }}
            </span>
        </div>

        @if ($todayTasks->isEmpty())
            <div class="empty-state">
                <p>No active tasks are scheduled for today.</p>
                @auth
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Today's First Task</a>
                @else
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline">Browse Full Task List</a>
                @endauth
            </div>
        @else
            <ul class="task-list">
                @foreach ($todayTasks as $task)
                    <li class="task-item">
                        <div class="task-info">
                            <span class="task-title {{ $task->status === 'done' ? 'is-done' : '' }}">
                                {{ $task->title }}
                            </span>
                            <span class="task-meta">
                                Due {{ $task->task_date->format('F j, Y') }}
                            </span>
                        </div>

                        <div class="task-actions">
                            <span class="badge {{ $task->status === 'done' ? 'badge-done' : ($task->status === 'in_progress' ? 'badge-in-progress' : 'badge-pending') }}">
                                {{ $task->status_label }}
                            </span>

                            @auth
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="margin: 0;"
                                      onsubmit="return confirm('Archive this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-sm">Archive</button>
                                </form>
                            @endauth
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
