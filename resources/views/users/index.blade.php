<x-app-layout title="Home">

    <x-slot name="heading">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            User List
        </div>
        <div class="card-body">
            <table id="usersDataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total assigned task</th>
                        <th>Total completed task</th>
                        <th>Total pending task</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const usersDataTable = document.getElementById('usersDataTable');
            if (usersDataTable) {
                new simpleDatatables.DataTable(usersDataTable);
            }

        </script>
    </x-slot>
</x-app-layout>
