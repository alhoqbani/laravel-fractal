<?php

namespace App\Transformers;

use App\Models\Post;
use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user',
    ];
    
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'comments',
    ];
    
    /**
     * Turn this item object into a generic array.
     *
     * @param \App\Models\Post $post
     *
     * @return array
     * @internal param \App\Models\User $user
     *
     */
    public function transform(Post $post)
    {
        return [
            'title'        => $post->title,
            'body_summary' => str_limit($post->body, 500),
            'path'         => $post->path,
        ];
    }

    /**
     * Include Comments.
     *
     * @param \App\Models\Post $post
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Post $post)
    {
        $user = $post->user;

        return $this->item($user, new UserTransformer());
    }

    /**
     * Include Comments.
     *
     * @param \App\Models\Post $post
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComments(Post $post)
    {
        $comments = $post->comments;

        return $this->collection($comments, function (Comment $comment) {
            return [
                'body'   => $comment->body,
                'author' => $comment->user->name,
            ];
        });
    }
}
