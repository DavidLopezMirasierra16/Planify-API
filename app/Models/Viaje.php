<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Viaje
 * 
 * @property int $id_viaje
 * @property int $origen_fk
 * @property int $destino_fk
 * @property Carbon $fecha_inicio
 * @property Carbon $fecha_final
 * @property int $numero_integrantes
 * @property int $vuelo_fk
 * @property int $hotel_fk
 * @property float $total_hotel_vuelo
 * @property int $id_creador_viaje
 * 
 * @property User $user
 * @property Destino $destino
 * @property Hotele $hotele
 * @property Origene $origene
 * @property Vuelo $vuelo
 * @property Collection|Actividade[] $actividades
 * @property Collection|Gasto[] $gastos
 * @property Collection|Integrante[] $integrantes
 * @property Collection|Itinerario[] $itinerarios
 * @property Collection|Tarea[] $tareas
 *
 * @package App\Models
 */
class Viaje extends Model
{
	protected $table = 'viajes';
	protected $primaryKey = 'id_viaje';
	public $timestamps = false;

	protected $casts = [
		'origen_fk' => 'int',
		'destino_fk' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_final' => 'datetime',
		'numero_integrantes' => 'int',
		'vuelo_fk' => 'int',
		'hotel_fk' => 'int',
		'total_hotel_vuelo' => 'float',
		'id_creador_viaje' => 'int'
	];

	protected $fillable = [
		'origen_fk',
		'destino_fk',
		'fecha_inicio',
		'fecha_final',
		'numero_integrantes',
		'vuelo_fk',
		'hotel_fk',
		'total_hotel_vuelo',
		'id_creador_viaje'
	];

	public function user_creador()
	{
		return $this->belongsTo(User::class, 'id_creador_viaje');
	}

	public function destino()
	{
		return $this->belongsTo(Destino::class, 'destino_fk');
	}

	public function hotele()
	{
		return $this->belongsTo(Hotele::class, 'hotel_fk');
	}

	public function origene()
	{
		return $this->belongsTo(Origene::class, 'origen_fk');
	}

	public function vuelo()
	{
		return $this->belongsTo(Vuelo::class, 'vuelo_fk');
	}

	public function actividades()
	{
		return $this->hasMany(Actividade::class, 'viaje_id');
	}

	public function gastos()
	{
		return $this->hasMany(Gasto::class, 'viaje_id');
	}

	public function integrantes()
	{
		return $this->hasMany(Integrante::class, 'viaje_fk');
	}

	public function itinerarios()
	{
		return $this->hasMany(Itinerario::class, 'id_viaje_fk');
	}

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'viaje_id');
	}
}
