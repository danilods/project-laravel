<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

use App\Validators\ProjectValidator;

use Illuminate\Contracts\Filesystem\Factory as Storage;

use Illuminate\Filesystem\Filesystem;

//Classe para implementar a regra de negócio para o Client

class ProjectService

{
	
protected $repository;

protected $validator;

protected $filesystem;

protected $storage;

public function __construct(ProjectRepository $repository, ProjectValidator $validator, 
	Filesystem $filesystem, Storage $storage){

	$this->repository = $repository;

	$this->validator = $validator;

	$this->filesystem = $filesystem;

	$this->storage = $storage;

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

public function createFile(array $data){

	//name
	//description
	//extension
	//file

	$project = $this->repository->skipPresenter()->find($data['project_id']);

	$projectFile = $project->files()->create($data);

	$this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));



}

}