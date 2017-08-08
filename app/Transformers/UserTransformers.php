<?php

namespace app\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'path' => $user->path,
        ];
    }
}
