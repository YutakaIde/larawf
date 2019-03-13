<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Workflow;

use App\Models\Project;
use App\Models\WorkflowLog;
use App\Models\WorkflowTemplate;
use App\Models\Task;

class AutoTask implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project_id;
    protected $workflow_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project_id, $workflow_name)
    {
        $this->project_id = $project_id;
        $this->workflow_name = $workflow_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('AutoTask:: start');

        $project = Project::find($this->project_id);
        $workflow = Workflow::get($project, $this->workflow_name);

        Log::debug($this->workflow_name);


        $place = key((array)$project->currentPlace);
        $task = Task::where('name', $place)->first();

        // excute the external program
        $commandline = $task->command_name . ' ' . $task->argument;
        $process = new Process($commandline);
        try {
            $process->mustRun();

            $workflow_template = WorkflowTemplate::where('name', $this->workflow_name)->first();

            $workflow_log = new WorkflowLog();

            $workflow_log->project_id = $project->id;
            $workflow_log->workflow_id = $workflow_template->id;
            $workflow_log->task_id = $task->id;
            $workflow_log->type = 'run';
            $workflow_log->stdout = $process->getOutput();
            $workflow_log->stderr = $process->getErrorOutput();

            $workflow_log->save();
            Log::debug($workflow_log->stdout);

        } catch (ProcessFailedException $e) {
            Log::debug($e->getMessage());
        }

        // if not last task, transite to next task
        $transitions = $workflow->getEnabledTransitions($project);
        if (!empty($transitions)) {
            Log::debug("AutoTask:: ${place}_finished .");
            $workflow->apply($project, "${place}_finished");
        }

        $project->save();

        Log::debug('AutoTask:: end');
    }
}
