<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Destino
 * 
 * @property int $id_destino
 * @property string $ciudad_destino
 * @property string|null $imagen_destino
 * @property string $iata_code
 * @property string $geoId
 * 
 * @property Collection|DestinoVuelo[] $destino_vuelos
 * @property Collection|Viaje[] $viajes
 *
 * @package App\Models
 */
class Destino extends Model
{
	protected $table = 'destinos';
	protected $primaryKey = 'id_destino';
	public $timestamps = false;

	protected $fillable = [
		'ciudad_destino',
		'imagen_destino',
		'iata_code',
		'geoId'
	];

	public function destino_vuelos()
	{
		return $this->hasMany(DestinoVuelo::class, 'destino_fk');
	}

	public function viajes()
	{
		return $this->hasMany(Viaje::class, 'destino_fk');
	}
}
