<?php

namespace App\Actions\_Base;

use App\Actions\Action;

class SuperAdminHomeAction extends Action
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        return view('home');
    }

}
