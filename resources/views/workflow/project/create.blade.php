@extends('layouts.default')
@section('title', 'WorkflowLog')
@section('content')

    <div class="container">

        <h4>Project Entry</h4>
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="http://larawf.test/workflow/project" accept-charset="UTF-8" role="form">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="ProjectName" class="col-sm-3 col-form-label">Project Name</label>
                        <div  class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="ProjectName" placeholder="Enter project name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="File" class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9" id="File">
                            <div class="progress flow-progress" style="height: 1px;">
                                <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" >
                                    <span class="sr-only">45% Complete</span>
                                </div>
                            </div>
                            <div class="flow-drop" ondragenter="jQuery(this).addClass('flow-dragover');" ondragend="jQuery(this).removeClass('flow-dragover');"  ondragleave="jQuery(this).removeClass('flow-dragover');" ondrop="jQuery(this).removeClass('flow-dragover');">
                                Just drag and drop files here
                            </div>
                            <input type="text" class="form-control" name="file_name" id="file_name" readonly>
                            <input type="text" class="form-control" name="file_id" id="file_id" readonly style="display:none;">
                        </div>
                    </div>

                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0">Translation</legend>
                            <div class="col-sm-9">

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workflow_id" value="1" id="workflow_id_1" checked>
                                    <label class="form-check-label" for="workflow_id_1">
                                        Japanese &rarr; English
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workflow_id" value="2" id="workflow_id_2">
                                    <label class="form-check-label" for="workflow_id_2">
                                        English &rarr; Italia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workflow_id" value="3" id="workflow_id_3">
                                    <label class="form-check-label" for="workflow_id_3">
                                        English &rarr; Arabic
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

    </div><!-- /.container -->

@endsection