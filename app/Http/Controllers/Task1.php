<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Workflow;
use Illuminate\Support\Facades\Log;

use App\Models\Project;


class Task1 extends Controller {

  public function finish() {

    $data = array();

    Log::info('Task1:: start .');

  	$project = Project::find(1);

  	$workflow = Workflow::get($project);

	  $workflow->apply($project, 'task1_finished');

    Log::info('Task1:: transition .');

    $project->save();

    Log::info('Task1:: save .');

    $data['name1'] = $project;

    Log::info('Task1:: end .');

    return view('task1', $data);

  }

}

