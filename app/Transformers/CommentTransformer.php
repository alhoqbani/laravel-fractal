<?php

namespace App\Transformers;

use App\Models\Post;
use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
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
        'post',
    ];
    
    /**
     * Turn this item object into a generic array.
     *
     * @param \App\Models\Comment $comment
     *
     * @return array
     * @internal param \App\Models\Post $post
     *
     * @internal param \App\Models\User $user
     */
    public function transform(Comment $comment)
    {
        return [
            'body'        => $comment->body,
            'created' => $comment->created_at->diffForHumans(),
        ];
    }
    
    /**
     * Include Comments.
     *
     * @param \App\Models\Comment $comment
     *
     * @return \League\Fractal\Resource\Item
     * @internal param \App\Models\Post $post
     *
     */
    public function includeUser(Comment $comment)
    {
        $user = $comment->user;

        return $this->item($user, new UserTransformer());
    }
    
    /**
     * Include Post.
     *
     * @param \App\Models\Comment $comment
     *
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Item
     * @internal param \App\Models\Post $post
     *
     */
    public function includePost(Comment $comment)
    {
        $post = $comment->post;

        return $this->item($post, function ($post) {
            return [
                'post' => $post->path
            ];
        });
    }
}
