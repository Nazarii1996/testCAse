<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Project;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $projects=new Project;
        if($request->input('title')){
            $projects=$projects->where('title','like','%'.$request->input('title').'%');
        }

        $projects=$projects->get();

        foreach($projects as &$project){
            $project->edit=route('admin.projects.edit',$project->id);
            $project->remove=route('admin.projects.destroy',$project->id);
            $project->show=route('admin.projects.show',$project->id);
        }

        return $projects;

    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->all());

        if ($request->input('attachments', false)) {
            $project->addMedia(storage_path('tmp/uploads/' . $request->input('attachments')))->toMediaCollection('attachments');
        }

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(Project $project)
    {
        abort_if(Gate::denies('project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectResource($project);

    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        if ($request->input('attachments', false)) {
            if (!$project->attachments || $request->input('attachments') !== $project->attachments->file_name) {
                $project->addMedia(storage_path('tmp/uploads/' . $request->input('attachments')))->toMediaCollection('attachments');
            }

        } elseif ($project->attachments) {
            $project->attachments->delete();
        }

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(Project $project)
    {
        abort_if(Gate::denies('project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
