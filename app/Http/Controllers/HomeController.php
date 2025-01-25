<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userCount = User::count();
        $tasks = Task::get();

        $inProgressTask = $tasks->where('status', 'Pending')->count();
        $completedTask = $tasks->where('status', 'In Progress')->count();
        $pendingTask = $tasks->where('status', 'Completed')->count();

        return view('home', compact('userCount', 'inProgressTask', 'completedTask', 'pendingTask', 'tasks'));
    }
}
