<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Repositories\ProjectRepository;
use App\Validators\ProjectValidator;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Storage;
use File;


class ProjectFileController extends Controller
{

  private $repository;

    private $service;

    
    public function __construct(ProjectRepository $repository, ProjectService $service){

        $this->repository = $repository;
                $this->service = $service;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->repository->findWhere(['owner_id'=> \Authorizer::getResourceOwnerId()]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->service->create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;

                $data['project_id'] = $request->project_id;
                                $data['description'] = $request->description;



        $this->service->createFile($data);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        
         if($this->checkProjectPermissions($id)==false){

            return ['error' => 'Acesso negado'];
         }
         return $this->repository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

         return $this->repository->find($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // colocar os campos vindo do $request em um array
        // $request=$attributes

        if($this->checkProjectOwner($id)==false){


             return ['error' => 'Acesso negado'];


         }

        return $this->service->update($request->all(),$id);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);

    }

    private function checkProjectOwner($projectId){

        $userId = \Authorizer::getResourceOwnerId();

         
        return $this->repository->isOwner($projectId, $userId);
              
    }

    private function checkProjectMember($projectId){

        $userId = \Authorizer::getResourceOwnerId();

         
        return $this->repository->hasMember($projectId, $userId);
              
    }

    private function checkProjectPermissions($projectId){
             if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
                return true;
             }
             return false;

    }


}
