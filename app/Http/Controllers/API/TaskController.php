<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TaskJsonResourceCollection;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;

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
        return new TaskJsonResourceCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'user' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) return new ErrorResource($validator->messages()->first());

        $input = $request->all();
        $this->taskRepository->save($input);

        return new SuccessResource("Task successfully created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = $this->taskRepository->findById($id);
        if(!$task) return new ErrorResource("Task not found.");

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'user' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) return new ErrorResource($validator->messages()->first());

        $input = $request->all();
        $this->taskRepository->update($input, $task);

        return new SuccessResource("Task successfully updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = $this->taskRepository->findById($id);
        if(!$task) return new ErrorResource("Task not found");

        $this->taskRepository->delete($task);

        return new SuccessResource("Task successfully deleted");
    }

    public function getUserList()
    {
        $users = $this->userRepository->list();
        return new TaskJsonResourceCollection($users);
    }
}
