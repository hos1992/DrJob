<?php

namespace App\Models;


use App\Actions\_Base\SuperAdminHomeAction;
use App\Actions\Post\PostIndexAction;
use App\Actions\User\UserIndexAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * @return Attribute
     */
    public function userHomeAction(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->hasRole('super-admin')) {
                    return App::call(new SuperAdminHomeAction());
                }
                if ($this->hasRole('admin')) {
                    return App::call(new UserIndexAction());
                }
                if ($this->hasRole('user')) {
                    return App::call(new PostIndexAction());
                }
            },
        );
    }
}
