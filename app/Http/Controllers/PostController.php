<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class PostController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @param \League\Fractal\Manager $fractal
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Manager $fractal)
    {
        $paginator = Post::paginate(3)->appends(request()->query());
        $posts = $paginator->getCollection();

        $resource = new Collection($posts, new PostTransformer(), 'posts');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $fractal->createData($resource)->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }
    
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post        $post
     *
     * @param \League\Fractal\Manager $manager
     *
     * @return array|\Illuminate\Http\Response
     */
    public function show(Post $post, Manager $manager)
    {
        $manager->parseIncludes('comments');
        return $manager->createData(new Item($post, new PostTransformer()))->toArray();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post         $post
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
    }
}
