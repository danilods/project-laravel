<?php

namespace App\Repositories;

use App\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\UserRepository;

class UserProjectRepositoryEloquent extends BaseRepository implements UserProjectRepository


{

public function model()

{

	return User::class;
}	

	
}