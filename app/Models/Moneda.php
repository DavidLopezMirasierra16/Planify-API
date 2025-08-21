<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Moneda
 * 
 * @property int $id_moneda
 * @property string $nombre_moneda
 *
 * @package App\Models
 */
class Moneda extends Model
{
	protected $table = 'monedas';
	protected $primaryKey = 'id_moneda';
	public $timestamps = false;

	protected $fillable = [
		'nombre_moneda'
	];
}
