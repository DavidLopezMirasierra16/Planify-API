<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tarea
 * 
 * @property int $id_tarea
 * @property string $nombre_tarea
 * @property int $asignada_fk
 * @property bool|null $completado
 * @property int $viaje_id
 * 
 * @property Integrante $integrante
 * @property Viaje $viaje
 *
 * @package App\Models
 */
class Tarea extends Model
{
	protected $table = 'tareas';
	protected $primaryKey = 'id_tarea';
	public $timestamps = false;

	protected $casts = [
		'asignada_fk' => 'int',
		'completado' => 'bool',
		'viaje_id' => 'int'
	];

	protected $fillable = [
		'nombre_tarea',
		'asignada_fk',
		'completado',
		'viaje_id'
	];

	public function integrante()
	{
		return $this->belongsTo(Integrante::class, 'asignada_fk');
	}

	public function viaje()
	{
		return $this->belongsTo(Viaje::class, 'id_viaje');
	}
}
