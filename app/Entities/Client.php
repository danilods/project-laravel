<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

	protected $fillable = [


		'name',
		'responsible',
		'telefone',
		'email',
		'endereco',
		'obs'


	];

}
 