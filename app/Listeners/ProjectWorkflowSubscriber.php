<?php

namespace App\Listeners;

use Brexis\LaravelWorkflow\Events\GuardEvent;
use Illuminate\Support\Facades\Log;
use App\Jobs\AutoTask;
use App\Models\Task;

class ProjectWorkflowSubscriber {
    /**
     * Handle workflow guard events.
     */
    public function onGuard(GuardEvent $event) {
    }

    /**
     * Handle workflow leave event.
     */
    public function onLeave($event) {}

    /**
     * Handle workflow transition event.
     */
    public function onTransition($event) {}

    /**
     * Handle workflow enter event.
     */
    public function onEnter($event) {
    }

    /**
     * Handle workflow entered event.
     */
    public function onEntered($event) {

        Log::info('ProjectWorkflowSubscriber:: onEntered start .');

        $originalEvent = $event->getOriginalEvent();
        $project_id = $originalEvent->getSubject()->id;
        $current_place = key((array)$originalEvent->getSubject()->currentPlace);
        $last_transition = $originalEvent->getTransition()->getName();

        Log::info($current_place);        
        $current_task = Task::where('name', $current_place)->first();
        Log::info($current_task);        

        if($current_task->type == 2) {
            $tmp = (new AutoTask($project_id))->delay(10);
            dispatch($tmp);
        }

        Log::info('ProjectWorkflowSubscriber:: onEntered end .');

    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events) {
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