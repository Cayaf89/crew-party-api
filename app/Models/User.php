<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property string profile_picture
 * @property string name
 * @property string email
 * @property \DateTime email_verified_at
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_picture',
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
    ];

    /**
     * @param $image
     *
     * @return void
     * @throws \Exception
     */
    public function setProfilePicture($image) {
        $profilePicture = Image::make($image)->fit(400, 400);
        $newProfilePicturePath = 'users/' . $this->id . '/profile-picture-' . time() . '.png';
        if (Storage::disk('public')->exists($this->profile_picture)) {
            Storage::disk('public')->delete($this->profile_picture);
        }
        Storage::disk('public')
               ->put($newProfilePicturePath, $profilePicture->encode());
        $this->profile_picture = $newProfilePicturePath;
    }

    public function getProfilePicture() {
        return env('APP_URL', 'https://crew-party-api.test') . Storage::url($this->profile_picture);
    }
}
