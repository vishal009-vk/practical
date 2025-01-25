<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(TaskRepositoryInterface $taskRepository, UserRepositoryInterface $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskRepository->list();

        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = $this->userRepository->list();

        return view('task.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'user' => 'required|exists:users,id',
        ]);

        $input = $request->all();
        $this->taskRepository->save($input);

        return redirect(route('tasks.index'))->with('success', 'Task successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = $this->userRepository->list();
        $task = $this->taskRepository->findById($id);

        if(!$task) abort('404');

        return view('task.edit', compact('users', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = $this->taskRepository->findById($id);
        if(!$task) abort('404');

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'user' => 'required|exists:users,id',
        ]);

        $input = $request->all();
        $this->taskRepository->update($input, $task);

        return redirect(route('tasks.index'))->with('success', 'Task successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = $this->taskRepository->findById($id);
        if(!$task) abort('404');

        $this->taskRepository->delete($task);

        return redirect(route('tasks.index'))->with('success', 'Task successfully deleted');
    }

}
