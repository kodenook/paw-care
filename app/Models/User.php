<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The function checks if the email address ends with "@pawcare.com" to determine if the user can
     * access the panel.
     *
     * @param Panel panel The parameter "panel" is of type "Panel".
     * @return bool a boolean value, either true or false.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@pawcare.com');
    }

    /**
     * The function "getFilamentName" returns the full name of a user.
     *
     * @return string the value of the variable `full_name`.
     */
    public function getFilamentName(): string
    {
        return $this->full_name;
    }
}
