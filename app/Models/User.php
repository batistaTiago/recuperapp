<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domain\DTO\UserDTO;
use App\Models\Traits\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

class User extends Authenticatable
{
    use BaseModel;
    use HasApiTokens, Notifiable;

    public $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'uuid');
    }

    public function toDto(): UserDTO
    {
        return new UserDTO(
            uuid: $this->uuid,
            name: $this->name,
            email: $this->email,
            email_verified_at: $this->email_verified_at,
            password: $this->password,
            remember_token: $this->remember_token,
        );
    }
}
