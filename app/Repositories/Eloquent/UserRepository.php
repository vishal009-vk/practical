<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return JsonResponse
     */
    public function list()
    {
        $user = User::whereUserType('User')
            ->select([
                'id',
                'unique_id',
                'first_name',
                'last_name',
                'email',
            ])
            ->get();
        
        return $user;
    }

    /**
     * @param $user_id
     * @return JsonResponse
     */
    public function findById($user_id)
    {
        $user = User::find($user_id);
        return $user;
    }

    /**
     * @param $input
     * @return JsonResponse
     */
    public function register($input) {
        $user = new User();
        $user->unique_id = Str::uuid();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        return true;
    }
}
