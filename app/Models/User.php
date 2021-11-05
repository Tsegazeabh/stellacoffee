<?php

namespace App\Models;

use App\Events\EmailVerificationRequested;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'account_disabled' => 'boolean'
    ];

    public static $actions = ['create', 'edit', 'disable', 'enable', 'send activation code', 'send password reset'];

    public $appends = ['email_verified', 'is_admin'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, "user_roles", 'user_id', 'role_id')->withTimestamps();
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('name', 'SuperAdmin')->exists();
    }

    public function isActive()
    {
        return !$this->account_disabled;
    }

    /**
     * Sends Account Verification Message
     */
    public function sendEmailVerificationNotification()
    {
        event(new EmailVerificationRequested($this));
//        $this->notify(new VerifyEmail);
    }

    public function getEmailVerifiedAttribute()
    {
        return $this->hasVerifiedEmail();
    }

    public function hasVerifiedEmail()
    {
        return !empty($this->email_verified_at);
    }

    public function passwordModified()
    {
        if ($this->is_admin || !$this->hasVerifiedEmail()) {
            return true;
        } else {
            if (!$this->must_change_password) {
                $diffInDays = Carbon::now()->diffInDays($this->password_modification_date);
                return $diffInDays <= config('custom_config.password_life_time');
            }
            return false;
        }
    }
}
