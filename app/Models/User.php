<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ChatThread;
use App\Models\ChatMessage;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'surname',
        'email',
        'password',
        'role',
        'status',
        'profile_photo',
        'phone',
        'address',
        'birthdate',
        'gender',
        'marital_status',
        'email_verification_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthdate' => 'date',
        ];
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is an official.
     */
    public function isOfficial(): bool
    {
        return $this->role === 'official';
    }

    /**
     * Check if user is a resident.
     */
    public function isResident(): bool
    {
        return $this->role === 'resident';
    }

    /**
     * Check if user can access the given Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Only allow approved users to access panels
        if ($this->status !== 'approved') {
            return false;
        }

        // Match panel ID with user role
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'official' => $this->role === 'official',
            'resident' => $this->role === 'resident',
            default => false,
        };
    }

    /**
     * Check if user status is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if user status is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Get the full name of the user.
     */
    public function getFullName(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->surname,
        ]);
        return implode(' ', $parts) ?: 'Unknown User';
    }

    /**
     * Get all notifications for this user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the online ID for this user.
     */
    public function onlineId(): HasOne
    {
        return $this->hasOne(OnlineId::class);
    }

    /**
     * Get resident chat thread.
     */
    public function chatThread(): HasOne
    {
        return $this->hasOne(ChatThread::class, 'resident_id');
    }

    /**
     * Get messages sent by this user.
     */
    public function sentChatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }
}
