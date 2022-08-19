<?php

namespace App\Actions\Post;

use App\Actions\Action;
use App\Models\Post;


class PostIndexAction extends Action
{


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function __invoke()
    {
        $data['posts'] = Post::AccordingToUserRole();

        if (request()->ajax()) {
            return view('posts.ajax.ajaxed_posts_table', ['data' => $data])->render();
        }

        return view('posts.index', ['data' => $data]);
    }

}
