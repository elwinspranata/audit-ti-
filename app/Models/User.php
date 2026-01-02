<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'is_approved',
        'role',
        'phone_number',
        'company_name',
        'department',
        'active_package_id',
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
        'subscription_start' => 'datetime',
        'subscription_end' => 'datetime',
    ];

    public function jawabans()
    {
        // Ganti 'Jawaban::class' jika nama model Anda berbeda
        return $this->hasMany(Jawaban::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function hasActiveSubscription()
    {
        return $this->subscription_status === 'active' 
            && $this->subscription_end 
            && $this->subscription_end->isFuture();
    }

    public function activateSubscription(Package $package)
    {
        $this->subscription_status = 'active';
        $this->active_package_id = $package->id;
        $this->subscription_start = now();
        $this->subscription_end = now()->addDays((int) $package->duration_days);
        $this->save();
    }

    /**
     * Relasi ke Assessments
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function activePackage()
    {
        return $this->belongsTo(Package::class, 'active_package_id');
    }

    /**
     * Get assessment aktif user (hanya 1 yang boleh aktif)
     */
    public function activeAssessment()
    {
        return $this->hasOne(Assessment::class)
            ->whereNotIn('status', [Assessment::STATUS_VERIFIED, Assessment::STATUS_REJECTED]);
    }

    /**
     * Check apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check apakah user adalah auditor
     */
    public function isAuditor(): bool
    {
        return $this->role === 'auditor';
    }

    /**
     * Check apakah user adalah user biasa
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
