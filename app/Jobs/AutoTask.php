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

        Log::info('AutoTask:: start .');

        $id = $this->param;
        $project = Project::find($id);

        $workflow = Workflow::get($project);

		$place = key((array)$project->currentPlace);

		if ($place == 'task2') {
        	$workflow->apply($project, "${place}_finished");
	        Log::info("AutoTask:: ${place}_finished .");
		}

        $project->save();

        Log::info('AutoTask:: end .');

    }
}
