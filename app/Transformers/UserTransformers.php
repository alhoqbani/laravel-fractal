<?php

namespace app\Transformers;

use App\Models\Avatar;
use App\Models\Post;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'avatar',
    ];
    
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'posts',
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @param \App\Models\User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'path' => $user->path,
        ];
    }

    /**
     * Include Posts.
     *
     * @param \App\Models\User $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includePosts(User $user)
    {
        $posts = $user->posts;

        return $this->collection($posts, function (Post $post) {
            return [
                'title' => $post->title,
            ];
        });
    }
    
    /**
     * Include Avatar.
     *
     * @param \App\Models\User $user
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAvatar(User $user)
    {
        $avatar = $user->avatar;

        return $this->item($avatar, function (Avatar $avatar) {
            return [
                'avatar_url' => $avatar->path,
            ];
        });
    }
}
