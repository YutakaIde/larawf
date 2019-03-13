@extends('layouts.default')
@section('title', 'WorkflowLog')
@section('content')

    <div class="container">

        <h4>Workflow Config</h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="timeline">
                    @foreach ($tasks as $task)
                    <li>
                        <a target="_blank" href="#">{{ $task->name }}</a>
                        <a href="#" class="float-right">
                            @switch ($task->type)
                                @case (1)
                                    Human Task
                                    @break
                                @case (2)
                                    Auto Task
                                    @break
                            @endswitch
                        </a>
                        <p>
                            @switch ($task->type)
                                @case (1)
                                {{ $task->url }}
                                @break
                                @case (2)
                                {{ $task->command_name }} {{ $task->argument }}

                                @break
                            @endswitch
                        </p>
                    </li>
                    @endforeach
                </ul>

            </div>

        </div><!-- /.container -->

@endsection