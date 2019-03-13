<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Workflow;

use App\Models\Project;
use App\Models\WorkflowTemplate;

class TaskController extends Controller
{

    public function finish($id)
    {
        Log::info('TaskController:: start');

        $project = Project::find($id);

        $workflow_template = WorkflowTemplate::find($project->workflow_id);

        $workflow = Workflow::get($project, $workflow_template->name);

        if (is_null($project->currentPlace)) {
            $workflow->apply($project, 'task1_finished');
        } else {
            $current_place = key((array)$project->currentPlace);
            $workflow->apply($project, "${current_place}_finished");
        }

        $project->save();

        Log::info('TaskController:: end');

        return redirect('workflow/workflow');
    }

}

