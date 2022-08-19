<?php

namespace App\Actions\User;

use App\Actions\Action;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserIndexAction extends Action
{


    public function __invoke()
    {

        $data['users'] = User::where([
            ['id', '!=', Auth::user()->id]
        ])->whereHas('roles', function ($q) {
            $q->where('name', '!=', 'super-admin');
        })->orderBy('id', 'DESC')->paginate(30);


        if (request()->ajax()) {
            return view('users.ajax.ajaxed_users_table', ['data' => $data])->render();
        }

        return view('users.index', ['data' => $data]);
    }

}
