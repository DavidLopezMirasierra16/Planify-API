<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Gasto
 * 
 * @property int $id_gastos
 * @property float $valor
 * @property int $integrante_fk
 * @property bool $pagado
 * @property string|null $descripcion
 * @property int $viaje_id
 * 
 * @property Integrante $integrante
 * @property Viaje $viaje
 *
 * @package App\Models
 */
class Gasto extends Model
{
	protected $table = 'gastos';
	protected $primaryKey = 'id_gastos';
	public $timestamps = false;

	protected $casts = [
		'valor' => 'float',
		'integrante_fk' => 'int',
		'pagado' => 'bool',
		'viaje_id' => 'int'
	];

	protected $fillable = [
		'valor',
		'integrante_fk',
		'pagado',
		'descripcion',
		'viaje_id'
	];

	public function integrante()
	{
		return $this->belongsTo(Integrante::class, 'integrante_fk');
	}

	public function viaje()
	{
		return $this->belongsTo(Viaje::class, 'id_viaje');
	}
}
