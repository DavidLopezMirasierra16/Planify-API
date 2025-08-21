<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $surnames
 * @property string $phone_number
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Role[] $roles
 * @property Collection|Viaje[] $viajes
 *
 * @package App\Models
 */
class User extends Model
{

	use HasFactory, Notifiable, HasApiTokens;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'surnames',
		'phone_number',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function roles()
	{
		return $this->belongsToMany(Role::class)
			->withPivot('id')
			->withTimestamps();
	}

	public function viajes()
	{
		return $this->hasMany(Viaje::class, 'id_creador_viaje');
	}

	public function hasRole($role)
	{
		if (is_string($role)) {
			//Si el rol es un string, verifica si existe en los roles del usuario
			return $this->roles->contains('name', $role);
		}
		if (is_array($role)) {
			//Si el rol es un array, conviértelo en una colección para usar intersect
			$role = collect($role);
		}
		//Comparar roles y verificar si hay intersección
		return !! $role->intersect($this->roles->pluck('name'))->count();
	}
}
