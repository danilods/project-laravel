<?php 
namespace App\Transformers;

use App\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;
use App\Transformers\ProjectMemberTransformer;

class ProjectNoteTransformer extends TransformerAbstract
{

	protected $defaultIncludes = ['members'];

	public function transform(ProjectNote $note)
	{

		return [
			'id' => $note->id,
			'project_id' => $note->project_id,
			'title' => $note->title,
			'note' => $note->note
			
		];

	}

	public function includeMembers(Project $project){

			return $this->collection($project->members, new ProjectMemberTransformer());
	}

}