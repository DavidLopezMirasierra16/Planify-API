<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Actividade
 * 
 * @property int $id_actividad
 * @property string $nombre_actividad
 * @property string $enlace_actividad
 * @property string $descripcion
 * @property string|null $direccion_actividad
 * @property float $precio
 * @property int $viaje_id
 * 
 * @property Viaje $viaje
 *
 * @package App\Models
 */
class Actividade extends Model
{
	protected $table = 'actividades';
	protected $primaryKey = 'id_actividad';
	public $timestamps = false;

	protected $casts = [
		'precio' => 'float',
		'viaje_id' => 'int'
	];

	protected $fillable = [
		'nombre_actividad',
		'enlace_actividad',
		'descripcion',
		'direccion_actividad',
		'precio',
		'viaje_id'
	];

	public function viaje()
	{
		return $this->belongsTo(Viaje::class);
	}
}
