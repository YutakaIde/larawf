@extends('layouts.default')
@section('title', 'Command Stdout')
@section('content')

    <div class="container">

        <h4>Command Stdout</h4>
        <div class="row">
            <div class="col-md-12">
                <blockquote class="blockquote">
                <pre>
                {{ $workflow_log->stdout  }}
                </pre>
                </blockquote>
            </div>

        </div><!-- /.container -->

@endsection