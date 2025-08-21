<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vuelo
 * 
 * @property int $id
 * @property int $vuelo_origen
 * @property int $vuelo_destino
 * @property float $precio_vuelo_total
 * 
 * @property DestinoVuelo $destino_vuelo
 * @property OrigenVuelo $origen_vuelo
 * @property Collection|Viaje[] $viajes
 *
 * @package App\Models
 */
class Vuelo extends Model
{
	protected $table = 'vuelos';
	public $timestamps = false;

	protected $casts = [
		'vuelo_origen' => 'int',
		'vuelo_destino' => 'int',
		'precio_vuelo_total' => 'float'
	];

	protected $fillable = [
		'vuelo_origen',
		'vuelo_destino',
		'precio_vuelo_total'
	];

	public function destino_vuelo()
	{
		return $this->belongsTo(DestinoVuelo::class, 'vuelo_destino');
	}

	public function origen_vuelo()
	{
		return $this->belongsTo(OrigenVuelo::class, 'vuelo_origen');
	}

	public function viajes()
	{
		return $this->hasMany(Viaje::class, 'vuelo_fk');
	}
}
