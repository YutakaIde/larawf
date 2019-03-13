@extends('layouts.default')
@section('title', 'WorkflowLog')
@section('content')

    <div class="container">

        <h4>Project</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>TimeStamp</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->current_place }}</td>
                                <td>{{ $project->created_at }}</td>
                                <td>
                                    @if(is_null($project->current_place) || $project->task_type == 1)
                                        <a class="btn btn-sm btn-primary" href="/workflow/task/{{ $project->id }}"
                                           role="button">Finish</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.container -->

@endsection