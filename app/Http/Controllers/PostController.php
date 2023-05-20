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
use App\Repositories\PostRepository;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    use HttpResponses;

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
     * Fetch posts by user
     * @return PostCollection
     */
    public function myPost()
    {
        $myPosts = Post::where('user_id', Auth::user()->id)->get();
        return new PostCollection($myPosts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return PostResource
     */
    public function store(StorePostRequest $request, PostRepository $repository)
    {
        $created = $repository->create($request->only([
            'title',
            'body',
            'category_id'
        ]));

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
    public function update(UpdatePostRequest $request, Post $post, PostRepository $repository)
    {
        if ($this->isNotAuthorized($post)) {
            return $this->isNotAuthorized($post);
        }

        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'category_id'
        ]));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        if ($this->isNotAuthorized($post)) {
            return $this->isNotAuthorized($post);
        }

        $post = $repository->forceDelete($post);

        return new JsonResponse([
            "data" => "success"
        ]);
    }

    /**
     * Authorize user to perform certain action.
     *
     * @param  \App\Models\Post  $post
     * @return JsonResponse
     */
    private function isNotAuthorized($post)
    {

        if (Auth::user()->id !== $post->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
