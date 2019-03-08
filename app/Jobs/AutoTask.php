<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

use Workflow;

use App\Models\Project;

class AutoTask implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($value) {
        $this->param = $value;    
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        Log::debug('AutoTask:: start .');

        $id = $this->param;

        $project = Project::find($id);
        $workflow = Workflow::get($project);

		$place = key((array)$project->currentPlace);

		// 最終の工程でないかチェックして工程の終了を行う
        $transitions = $workflow->getEnabledTransitions($project);
        if (!empty($transitions)) {
		    Log::debug("AutoTask:: ${place}_finished .");
	        $workflow->apply($project, "${place}_finished");
        }

        $project->save();
        Log::debug('AutoTask:: end .');

    }
}
