<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DateTimeInterface;
use Illuminate\Support\Str; // Importa Str
use Laravel\Sanctum\NewAccessToken; // Importa NewAccessToken

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'email_alternative',
        'password',
        'birth_date',
        'phone_number',
        'gender',
        'avatar'
    ];

    /**
     * Summary of dates
     * @var array
     */
    protected $dates = ['birth_date'];

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

    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        // Generate a random token
        do {
            $plainTextToken = Str::random(60); // Generate random token 
            $hashedToken = hash('sha256', $plainTextToken); // Hased token
        } while ($this->tokens()->where('token', $hashedToken)->exists()); // Verifi if token exists    

        // Create a token
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => $hashedToken,
            'abilities' => $abilities,
            'expires_at' => $expiresAt ?: now()->addHours(24),
        ]);

        return new NewAccessToken($token, $plainTextToken);
    }

    /**
     * Definir la relacion de los viajes con el usuario
     */
    public function travels()
    {
        return $this->hasMany(Travel::class, 'id_user');
    }

    /**
     * Definir la relacion de los viajes favoritos con el usuario
     */
    public function favoriteTravels()
    {
        return $this->hasMany(FavoriteTravel::class);
    }
}
