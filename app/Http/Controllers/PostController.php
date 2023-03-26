<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return PostCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;

        $posts = Post::query()->paginate($pageSize);
        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return PostResource
     */
    public function store(StorePostRequest $request)
    {
        $created = DB::transaction(function() use($request){
            $created = Post::query()->create([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            $created->users()->sync($request->user_ids);

            return $created;

        });

        return new PostResource($created);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return PostResource|JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //$post->update($request->only(['title','body']));
        // or

        $updated = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body ?? $post->body,
        ]);

        if(!$updated) {
            return new JsonResponse([
                'errors' => [
                    'Failed to update model.'
                ]
            ],400);
        }

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
       $deleted = $post->forceDelete();

       if(!$deleted) {
            return new JsonResponse([
                "errors" => [
                    'Could not delete resource.'
                ]
            ]);
       }

       return new JsonResponse([
        "data" => "success"
       ]);
    }
}
