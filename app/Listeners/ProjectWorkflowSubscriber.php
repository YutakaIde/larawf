<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

use Brexis\LaravelWorkflow\Events\GuardEvent;

use App\Models\WorkflowLog;
use App\Models\WorkflowTemplate;
use App\Models\Task;

use App\Jobs\AutoTask;

class ProjectWorkflowSubscriber
{
    /**
     * Handle workflow guard events.
     */
    public function onGuard(GuardEvent $event)
    {
    }

    /**
     * Handle workflow leave event.
     */
    public function onLeave($event)
    {
        Log::debug('ProjectWorkflowSubscriber::onLeave start');

        $originalEvent = $event->getOriginalEvent();

        $project = $originalEvent->getSubject();

        $workflow_template_name = $originalEvent->getWorkflowName();
        $workflow_template = WorkflowTemplate::where('name', $workflow_template_name)->first();

        Log::debug($workflow_template_name);

        $current_place = key((array)$originalEvent->getSubject()->currentPlace);
        $task = Task::where('name', $current_place)->first();

        Log::debug($task->id);

        $transition = $originalEvent->getTransition()->getName();

        $workflow_log = new WorkflowLog();

        $workflow_log->project_id = $project->id;
        $workflow_log->workflow_id = $workflow_template->id;
        $workflow_log->task_id = $task->id;
        $workflow_log->type = 'end';

        $workflow_log->save();

        Log::debug('ProjectWorkflowSubscriber::onLeave end');
    }

    /**
     * Handle workflow transition event.
     */
    public function onTransition($event)
    {
    }

    /**
     * Handle workflow enter event.
     */
    public function onEnter($event)
    {
    }

    /**
     * Handle workflow entered event.
     */
    public function onEntered($event)
    {
        Log::debug('ProjectWorkflowSubscriber::onEntered start');

        $originalEvent = $event->getOriginalEvent();

        $project = $originalEvent->getSubject();

        $workflow_template_name = $originalEvent->getWorkflowName();
        $workflow_template = WorkflowTemplate::where('name', $workflow_template_name)->first();

        $current_place = key((array)$originalEvent->getSubject()->currentPlace);
        $task = Task::where('name', $current_place)->first();

        $transition = $originalEvent->getTransition()->getName();


        // 自動工程の時にタスクを起動する
        if ($task->type == 2) {
            Log::debug('ProjectWorkflowSubscriber:: dispatch auto task .');
            $tmp = (new AutoTask($project->id, $workflow_template_name))->delay(10);
            dispatch($tmp);
        }

        $workflow_log = new WorkflowLog();

        $workflow_log->project_id = $project->id;
        $workflow_log->workflow_id = $workflow_template->id;
        $workflow_log->task_id = $task->id;
        $workflow_log->type = 'start';

        $workflow_log->save();

        Log::debug('ProjectWorkflowSubscriber::onEntered end');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Brexis\LaravelWorkflow\Events\GuardEvent',
            'App\Listeners\ProjectWorkflowSubscriber@onGuard'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\LeaveEvent',
            'App\Listeners\ProjectWorkflowSubscriber@onLeave'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\TransitionEvent',
            'App\Listeners\ProjectWorkflowSubscriber@onTransition'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\EnterEvent',
            'App\Listeners\ProjectWorkflowSubscriber@onEnter'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\EnteredEvent',
            'App\Listeners\ProjectWorkflowSubscriber@onEntered'
        );
    }

}