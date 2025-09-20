<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'position',
        'department',
        'address',
        'avatar',
        'last_login_at',
        'warehouse_id',
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
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role of the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the public requests assigned to this user.
     */
    public function assignedRequests()
    {
        return $this->hasMany(PublicRequest::class, 'assigned_to');
    }

    /**
     * Relation avec l'entrepôt (pour les responsables)
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Relation avec les préférences de notification
     */
    public function notificationPreferences()
    {
        return $this->hasOne(NotificationPreference::class);
    }

    /**
     * Obtenir ou créer les préférences de notification
     */
    public function getNotificationPreferences()
    {
        return $this->notificationPreferences ?? NotificationPreference::createDefaultForUser($this->id);
    }

    /**
     * Vérifier si l'utilisateur souhaite recevoir un type de notification
     */
    public function wantsNotification($type)
    {
        $preferences = $this->getNotificationPreferences();
        return $preferences->isEnabled($type);
    }

    /**
     * Check if user has a specific role.
     * Accepts either a numeric role ID or a role name (string).
     * Also accepts an array of IDs or names.
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            foreach ($role as $singleRole) {
                if ($this->hasRole($singleRole)) {
                    return true;
                }
            }
            return false;
        }

        if (is_numeric($role)) {
            return (int) $this->role_id === (int) $role;
        }

        return $this->role && $this->role->name === $role;
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    /**
     * Check if user is DG.
     */
    public function isDG()
    {
        return $this->role_id === 2;
    }

    /**
     * Check if user is responsable.
     */
    public function isResponsable()
    {
        return $this->role_id === 3;
    }

    /**
     * Check if user is agent.
     */
    public function isAgent()
    {
        return $this->role_id === 4;
    }
}

