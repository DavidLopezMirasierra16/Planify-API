<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Itinerario
 * 
 * @property int $id
 * @property int $id_viaje_fk
 * @property string $nombre
 * @property string|null $descripcion
 * @property Carbon $fecha_hora
 * @property string|null $ubicacion
 * 
 * @property Viaje $viaje
 *
 * @package App\Models
 */
class Itinerario extends Model
{
	protected $table = 'itinerarios';
	public $timestamps = false;

	protected $casts = [
		'id_viaje_fk' => 'int',
		'fecha_hora' => 'datetime'
	];

	protected $fillable = [
		'id_viaje_fk',
		'nombre',
		'descripcion',
		'fecha_hora',
		'ubicacion'
	];

	public function viaje()
	{
		return $this->belongsTo(Viaje::class, 'id_viaje_fk');
	}
}
