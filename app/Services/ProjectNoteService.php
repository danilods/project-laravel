<?php

namespace App\Services;

use App\Repositories\ProjectNoteRepository;

use App\Validators\ProjectNoteValidator;

//Classe para implementar a regra de negócio para o Client

class ProjectNoteService

{
protected $repository;

protected $validator;

public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator){

	$this->repository = $repository;

	$this->validator = $validator;

}


public function create(array $data){


	//enviar email
	//disparar notificacao
	//postar algo
		try{

			$this->validator->with($data)->passesOrFail();

			return $this->repository->create($data);
		} 
		catch(ValidatorException $e){

			return [
			'error' => true,
			'message' => $e->getMessageBag()

			];

		}


	

}

public function update(array $data, $id){


		try{
			$this->validator->with($data)->passesOrFail();

			return $this->repository->update($data, $id);
		} catch(ValidatorException $e){

			return [
			'error' => true,
			'message' => $e->getMessageBag()

			];

		}
		}

}