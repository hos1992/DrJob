<?php

namespace App\Actions\User;

use App\Actions\Action;

class UserUpdateAction extends Action
{

    private $model;
    private $data;

    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }

    public function __invoke()
    {
        $updateArr = [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
        ];

        if (isset($this->data['password']) && !empty($this->data['password'])) {
            $updateArr['password'] = bcrypt($this->data['password']);
        }


        $this->model->update($updateArr);

        if (request()->ajax()) {
            return [
                'status' => 1,
            ];
        }

        return redirect()->back();

    }

}
