<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $users = User::query()->get();
       return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(Request $request,UserRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'email',
        ]));

        return new UserResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return UserResource
     */
    public function show($user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return UserResource|JsonResponse
     */
    public function update(Request $request, User $user,UserRepository $repository)
    {
        $user = $repository->update($user, $request->only([
            'name',
            'email',
        ]));

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user,UserRepository $repository)
    {
        $repository->forceDelete($user);
        return new JsonResponse([
            'data' => 'success',
        ]);
    }
}
