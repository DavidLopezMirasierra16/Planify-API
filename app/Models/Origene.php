<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Origene
 * 
 * @property int $id_origen
 * @property string $ciudad
 * @property string|null $imagen_origen
 * @property string $iata_code
 * @property string $geoId
 * 
 * @property Collection|OrigenVuelo[] $origen_vuelos
 * @property Collection|Viaje[] $viajes
 *
 * @package App\Models
 */
class Origene extends Model
{
	protected $table = 'origenes';
	protected $primaryKey = 'id_origen';
	public $timestamps = false;

	protected $fillable = [
		'ciudad',
		'imagen_origen',
		'iata_code',
		'geoId'
	];

	public function origen_vuelos()
	{
		return $this->hasMany(OrigenVuelo::class, 'origen_fk');
	}

	public function viajes()
	{
		return $this->hasMany(Viaje::class, 'origen_fk');
	}
}
