<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CommentCollection
     */
    public function index()
    {
        $comments = Comment::query()->get();
        return new CommentCollection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request)
    {
        $created = Comment::query()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return CommentResource
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return CommentResource|JsonResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //$comment->update($request->only(['title','body']));
        // or

        $updated = $comment->update([
            'title' => $request->title ?? $comment->title,
            'body' => $request->body ?? $comment->body,
        ]);

        if(!$updated) {
            return new JsonResponse([
                'errors' => [
                    'Failed to update model.'
                ]
            ],400);
        }

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();

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
