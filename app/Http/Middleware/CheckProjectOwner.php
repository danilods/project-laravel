<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\ProjectRepository;

class CheckProjectOwner
{

    private $repository;


    public function __construct(ProjectRepository $repository){
        $this->repository=$repository;

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        $userId = \Authorizer::getResourceOwnerId();

        $projectId = $request->project;
         
                if($this->repository->isOwner($projectId, $userId) == false){

                   return ['error'=> 'Acesso negado'];
                }


        return $next($request);
    }
}
