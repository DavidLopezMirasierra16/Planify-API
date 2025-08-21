<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Integrante
 * 
 * @property int $id_integrante
 * @property int $viaje_fk
 * @property string $nombre
 * @property string $apellidos
 * @property int|null $edad
 * 
 * @property Viaje $viaje
 * @property Collection|Gasto[] $gastos
 * @property Collection|Tarea[] $tareas
 *
 * @package App\Models
 */
class Integrante extends Model
{
	protected $table = 'integrantes';
	protected $primaryKey = 'id_integrante';
	public $timestamps = false;

	protected $casts = [
		'viaje_fk' => 'int',
		'edad' => 'int'
	];

	protected $fillable = [
		'viaje_fk',
		'nombre',
		'apellidos',
		'edad'
	];

	public function viaje()
	{
		return $this->belongsTo(Viaje::class, 'viaje_fk');
	}

	public function gastos()
	{
		return $this->hasMany(Gasto::class, 'integrante_fk');
	}

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'asignada_fk');
	}
}
