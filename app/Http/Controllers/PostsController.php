<?php

namespace App\Http\Controllers;

use App\Actions\Post\PostIndexAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:index-post'])->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return App::call(new PostIndexAction());
    }
}
