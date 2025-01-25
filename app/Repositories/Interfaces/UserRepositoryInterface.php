<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * @return JsonResponse
     */
    public function list();

    /**
     * @param $user_id
     * @return JsonResponse
     */
    public function findById($user_id);
    
    /**
     * @param $input
     * @return JsonResponse
     */
    public function register($input);
}
