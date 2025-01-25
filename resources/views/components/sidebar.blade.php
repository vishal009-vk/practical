<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            SB Admin <sup>2</sup>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if (auth()->user()->user_type == "Admin")
        <hr class="sidebar-divider my-0">
        
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-users fa-table"></i>
                <span>Users</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider my-0">
    
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('tasks.index') }}">
            <i class="fas fa-tasks fa-table"></i>
            <span>Task</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">
    
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('vue.task.component') }}">
            <i class="fas fa-tasks fa-table"></i>
            <span>Vue Task Component</span>
        </a>
    </li>

    <hr class="sidebar-divider">
</ul>
