<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @return JsonResponse
     */
    public function list()
    {
        $tasks = Task::with('user')->get();

        return $tasks;
    }

    /**
     * @param $input
     * @return JsonResponse
     */
    public function save($input)
    {
        $task = new Task();
        $task->unique_id = Str::uuid();
        $task->user_id = $input['user'] ?? Auth::id();
        $task->title = $input['title'];
        $task->slug = Str::slug($input['title']);
        $task->description = $input['description'];
        $task->status = $input['status'] ?? 'Pending';
        $task->save();

        return true;
    }

    /**
     * @param $task
     * @return JsonResponse
     */
    public function findById($task)
    {
        $tasks = Task::whereUniqueId($task)->first();

        return $tasks;
    }

    /**
     * @param $task
     * @param $input
     * @return JsonResponse
     */
    public function update($input, $task)
    {
        $task->user_id = $input['user'] ?? Auth::id();
        $task->title = $input['title'];
        $task->slug = Str::slug($input['title']);
        $task->description = $input['description'];
        $task->status = $input['status'] ?? 'Pending';
        $task->save();

        return true;
    }

    /**
     * @param $task
     * @return JsonResponse
     */
    public function delete($task)
    {
        $task->delete();

        return true;
    }
}
