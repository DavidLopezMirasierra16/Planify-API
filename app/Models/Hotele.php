<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hotele
 * 
 * @property int $id
 * @property string $nombre
 * @property string|null $informacion
 * @property string $rating
 * @property string $proveedor
 * @property float $precio
 * @property string|null $url_info
 * 
 * @property Collection|Viaje[] $viajes
 *
 * @package App\Models
 */
class Hotele extends Model
{
	protected $table = 'hoteles';
	public $timestamps = false;

	protected $casts = [
		'precio' => 'float'
	];

	protected $fillable = [
		'nombre',
		'informacion',
		'rating',
		'proveedor',
		'precio',
		'url_info'
	];

	public function viajes()
	{
		return $this->hasMany(Viaje::class, 'hotel_fk');
	}
}
