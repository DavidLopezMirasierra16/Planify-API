<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrigenVuelo
 * 
 * @property int $id
 * @property int $origen_fk
 * @property string $origen_terminal_salida
 * @property string $origen_terminal_llegada
 * @property string $origen_salida
 * @property string $origen_llegada
 * @property string $origen_vuelo
 * @property string $origen_coste_vuelo
 * 
 * @property Origene $origene
 * @property Collection|Vuelo[] $vuelos
 *
 * @package App\Models
 */
class OrigenVuelo extends Model
{
	protected $table = 'origen_vuelos';
	public $timestamps = false;

	protected $casts = [
		'origen_fk' => 'int'
	];

	protected $fillable = [
		'origen_fk',
		'origen_terminal_salida',
		'origen_terminal_llegada',
		'origen_salida',
		'origen_llegada',
		'origen_vuelo',
		'origen_coste_vuelo'
	];

	public function origene()
	{
		return $this->belongsTo(Origene::class, 'origen_fk');
	}

	public function vuelos()
	{
		return $this->hasMany(Vuelo::class, 'vuelo_origen');
	}
}
