<?php

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    /**
     * @return JsonResponse
     */
    public function list();
    
    /**
     * @param $input
     * @return JsonResponse
     */
    public function save($input);

    /**
     * @param $task
     * @return JsonResponse
     */
    public function findById($task);
    
    /**
     * @param $task
     * @param $input
     * @return JsonResponse
     */
    public function update($input, $task);
    
    /**
     * @param $task
     * @return JsonResponse
     */
    public function delete($task);
}
