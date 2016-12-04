<?php

namespace App\Repositories;

use App\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements InterfaceRepository


{

public function model()

{

	return Client::class;
}	

	
}