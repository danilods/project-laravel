<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProjectNoteCreateRequest;
use App\Http\Requests\ProjectNoteUpdateRequest;
use App\Repositories\ProjectNoteRepository;
use App\Services\ProjectNoteService;


class ProjectNotesController extends Controller
{

   private $repository;

    private $service;

    
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service){

        $this->repository = $repository;
                $this->service = $service;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        return $this->repository->findWhere(['project_id' => $id]);

        
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
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $noteId)
    {
         
         return $this->repository->findWhere(['project_id' => $id, 'id'=>$noteId]);
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
    public function update(Request $request, $id, $noteId)
    {

        // colocar os campos vindo do $request em um array
        // $request=$attributes

        return $this->service->update($request->all(),$id, $noteId);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $noteId)
    {
        return $this->repository->delete($noteId);

    }
}
