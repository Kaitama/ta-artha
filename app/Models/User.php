<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'check_in',
        'point',
        'hours',
        'name',
        'gender',
        'username',
        'is_active',
        'description',
        'joined_at',
        'phone',
        'email',
        'password',
        'birthplace',
        'birthdate',
        'religion',
        'education',
        'major',
        'university',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'joined_at' => 'datetime:Y-m-d',
        'birthdate' => 'date:Y-m-d',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'role_display_name',
        'religion_text',
        'education_text',
    ];

    public array $educations = [
        1 => 'SMA',
        2 => 'D1',
        3 => 'D3',
        4 => 'S1',
        5 => 'S2',
        6 => 'S3'
    ];

    public array $religions = [
        1 => 'Buddha',
        2 => 'Islam',
        3 => 'Hindu',
        4 => 'Katolik',
        5 => 'Khonghucu',
        6 => 'Protestan'
    ];

    public function checkIn(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value ? Carbon::parse($value)->format('H:i') : '',
        );
    }

    public function educationText(): Attribute
    {
        return Attribute::make(
            get: fn (): string|null => $this->education ? $this->educations[$this->education] : null,
        );
    }

    public function religionText(): Attribute
    {
        return Attribute::make(
            get: fn (): string|null => $this->religion ? $this->religions[$this->religion] : null,
        );
    }

    public function roleDisplayName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->roles()->exists() ? ucwords(str_replace('-', ' ', $this->roles->first()->name)) : '-',
        );
    }

    public function cashflows(): HasMany
    {
        return $this->hasMany(Cashflow::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function absenceValidations(): HasMany
    {
        return $this->hasMany(AbsenceValidation::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function teachinghours(): HasMany
    {
        return $this->hasMany(Teachinghour::class);
    }

    public function rosters(): HasMany
    {
        return $this->hasMany(Roster::class);
    }

    public function hitungGaji(int $hours = 0): int
    {
        // guru tetap, kepsek, kasir
        if($this->point) {
            return $this->point * $this->roles->first()->rate;
        }
        // guru honor
        elseif ($this->hours) {
            return $hours * $this->roles->first()->rate;
        }
        // pegawai, bendahara, dll
        else {
            return $this->roles->first()->base;
        }
    }
}
