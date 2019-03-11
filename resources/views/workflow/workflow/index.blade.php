@extends('layouts.default')
@section('title', 'WorkflowLog')
@section('content')

    <div class="container">

        <h4>Workflow</h4>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                    <tr>
                        <th>Project</th>
                        <th>Workflow</th>
                        <th>Task</th>
                        <th>Type</th>
                        <th>TimeStamp</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($workflow_logs as $workflow_log)
                        <tr>
                            <td>{{ $workflow_log->project_id }}</td>
                            <td>{{ $workflow_log->workflow_id }}</td>
                            <td>{{ $workflow_log->task_id }}</td>
                            <td>{{ $workflow_log->type }}</td>
                            <td>{{ $workflow_log->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div><!-- /.container -->

@endsection