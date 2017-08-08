<?php

namespace app\Transformers;

use App\Models\Post;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'posts',
        'comments',
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
}
