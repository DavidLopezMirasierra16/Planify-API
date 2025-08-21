<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DestinoVuelo
 * 
 * @property int $id
 * @property int $destino_fk
 * @property string $destino_terminal_salida
 * @property string $destino_terminal_llegada
 * @property string $destino_salida
 * @property string $destino_llegada
 * @property string $destino_vuelo
 * @property string $destino_coste_vuelo
 * 
 * @property Destino $destino
 * @property Collection|Vuelo[] $vuelos
 *
 * @package App\Models
 */
class DestinoVuelo extends Model
{
	protected $table = 'destino_vuelos';
	public $timestamps = false;

	protected $casts = [
		'destino_fk' => 'int'
	];

	protected $fillable = [
		'destino_fk',
		'destino_terminal_salida',
		'destino_terminal_llegada',
		'destino_salida',
		'destino_llegada',
		'destino_vuelo',
		'destino_coste_vuelo'
	];

	public function destino()
	{
		return $this->belongsTo(Destino::class, 'destino_fk');
	}

	public function vuelos()
	{
		return $this->hasMany(Vuelo::class, 'vuelo_destino');
	}
}
