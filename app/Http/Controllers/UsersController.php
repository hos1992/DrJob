<?php

namespace App\Http\Controllers;

use App\Actions\User\UserIndexAction;
use App\Actions\User\UserStoreAction;
use App\Actions\User\UserUpdateAction;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function Termwind\render;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:index-user'])->only(['index']);
        $this->middleware(['can:create-user'])->only(['create', 'store']);
        $this->middleware(['can:show-user'])->only(['show']);
        $this->middleware(['can:edit-user'])->only(['edit', 'update']);
        $this->middleware(['can:delete-user'])->only(['delete']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return App::call(new UserIndexAction());
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        return App::call(new UserStoreAction($request->only([
            'name', 'email', 'password'
        ])));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        return App::call(new UserUpdateAction(User::find($id), $request->only([
            'name', 'email', 'password'
        ])));
    }

    /**
     * @param $id
     * @return int[]
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return [
            'status' => 1
        ];
    }


    /**
     * @param Request $request
     * @return array
     */
    public function toggleActiveState(Request $request)
    {
        $user = User::find($request->user_id);
        $user->is_active = !$user->is_active;
        $user->save();
        return [
            'status' => 1,
            'message' => 'success',
        ];
    }
}
