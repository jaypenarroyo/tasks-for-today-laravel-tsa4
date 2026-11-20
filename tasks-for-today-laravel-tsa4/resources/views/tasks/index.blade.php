@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Task Management</p>
            <h1 class="page-title">All Tasks</h1>
            <p class="page-subtitle">
                Active (non-archived) tasks ordered chronologically by date.
            </p>
        </div>
        <div class="header-actions">
            @auth
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Log in to Manage Tasks</a>
            @endauth
        </div>
    </div>

    <section class="stats-grid" aria-label="Task Overview">
        <div class="stat-card">
            <p class="stat-label">Active Tasks</p>
            <p class="stat-value">{{ $stats['total'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Due Today</p>
            <p class="stat-value">{{ $stats['today'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Pending</p>
            <p class="stat-value">{{ $stats['pending'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Done</p>
            <p class="stat-value">{{ $stats['done'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Archived</p>
            <p class="stat-value">{{ $stats['archived'] }}</p>
        </div>
    </section>

    <section class="card">
        <div class="card-header">
            <h2 class="card-title">Complete Task List</h2>
            <span class="task-meta">Ordered by task_date (ascending)</span>
        </div>

        @if ($tasks->isEmpty())
            <div class="empty-state">
                <p>No active tasks found.</p>
                @auth
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create a Task</a>
                @endauth
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            @auth
                                <th>Actions</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="task-title {{ $task->status === 'done' ? 'is-done' : '' }}">
                                        {{ $task->title }}
                                    </span>
                                </td>
                                <td>
                                    {{ $task->task_date->format('M j, Y') }}
                                    @if ($task->task_date->isSameDay($today))
                                        <span class="badge badge-today">Today</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $task->status === 'done' ? 'badge-done' : ($task->status === 'in_progress' ? 'badge-in-progress' : 'badge-pending') }}">
                                        {{ $task->status_label }}
                                    </span>
                                </td>
                                @auth
                                    <td>
                                        <div class="task-actions">
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline btn-sm">Edit</a>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="margin: 0;"
                                                  onsubmit="return confirm('Archive this task?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-outline btn-sm">Archive</button>
                                            </form>
                                        </div>
                                    </td>
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
