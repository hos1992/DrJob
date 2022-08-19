<?php

namespace App\Actions\User;

use App\Actions\Action;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserStoreAction extends Action
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke()
    {
        $user = User::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => bcrypt($this->data['password']),
        ]);

        try {
            $user->assignRole(Role::where('name', 'user')->first());
        } catch (\Exception $e) {
            //
        }

        if (request()->ajax()) {
            return [
                'status' => 1,
                'redirectUrl' => route('users.index'),
            ];
        }

        return redirect()->route('users.index');

    }

}
