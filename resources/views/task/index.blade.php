<x-app-layout title="Home">

    <x-slot name="heading">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tasks</h1>

            <a href="{{ route('tasks.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Add Task
            </a>
        </div>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tasks me-1"></i>
            Task List
        </div>
        <div class="card-body">
            <table id="taskDataTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Total completed task</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->user->last_name ?? '' }} {{ $task->user->last_name ?? ''}}</td>
                        <td>{{ $task->status }}</td>
                        <td>1</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->unique_id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a onclick="event.preventDefault(); document.getElementById('task-delete-form-{{ $task->unique_id }}').submit();" href="{{ route('tasks.destroy', $task->unique_id) }}" class="btn btn-sm btn-danger">Delete</a>

                            <form id="task-delete-form-{{ $task->unique_id }}" action="{{ route('tasks.destroy', $task->unique_id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const taskDataTable = document.getElementById('taskDataTable');
            if (taskDataTable) {
                new simpleDatatables.DataTable(taskDataTable);
            }

        </script>
    </x-slot>
</x-app-layout>
