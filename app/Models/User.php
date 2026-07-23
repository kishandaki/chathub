<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'chat_conversation_members', 'user_id', 'conversation_id')
            ->withPivot([
                'member_role','can_send','can_upload','is_muted','last_read_message_id',
                'last_read_at','unread_count','encryption_join_version','joined_at','left_at','removed_by',
            ])
            ->withTimestamps();
    }

    public function presence()
    {
        return $this->hasOne(ChatUserPresence::class, 'user_id');
    }

    public function devices()
    {
        return $this->hasMany(ChatUserDevice::class, 'user_id');
    }

    public function notificationPreference()
    {
        return $this->hasOne(ChatNotificationPreference::class, 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'last_active_at' => 'datetime',
            'password_changed_at' => 'datetime',
            'locked_until' => 'datetime',
            'mfa_enabled' => 'boolean',
            'failed_login_attempts' => 'integer',
            'password' => 'hashed',
        ];
    }
}
