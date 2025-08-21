<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Idioma
 * 
 * @property int $id_idioma
 * @property string $lengua
 *
 * @package App\Models
 */
class Idioma extends Model
{
	protected $table = 'idiomas';
	protected $primaryKey = 'id_idioma';
	public $timestamps = false;

	protected $fillable = [
		'lengua'
	];
}
