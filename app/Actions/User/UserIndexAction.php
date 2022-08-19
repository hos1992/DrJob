<?php

namespace App\Actions\User;

use App\Actions\Action;

class UserIndexAction extends Action
{

    public function __invoke()
    {
        return view('users.index');
    }

}
