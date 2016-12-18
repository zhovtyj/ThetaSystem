@extends('main')

@section('title', 'Settings')

@section('stylesheets')
    <!--Validation-->
    {!! Html::style('/public/css/parsley.css') !!}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1>Settings</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">
                <table class="table" id="users-table">
                    <tr>
                        <th>Name</th>
                        <th>Enabled</th>
                        <th>Role</th>
                        <th>Progress</th>
                    </tr>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>@if($user->enabled == true) true @else false @endif</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $user->percentage }}"
                                     aria-valuemin="0" aria-valuemax="100" style="width:{{ $user->percentage }}%">
                                    <span class="li-progress-bar-span">{{ $user->completed }}/{{ $user->total }} (%{{ $user->percentage }})</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>

            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Add user
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadCSV">
                            Upload CSV
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Add User -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                {!! Form::open(['route' => 'save.user', 'method' => 'post', 'id' => 'save-user', 'data-parsley-validate' =>'']) !!}

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add user</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            {{ Form::label('name', 'Name:') }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('password', 'Password:') }}
                            {{ Form::password('password', ['class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('enabled', 'Enabled:') }}
                            <select class="form-control" name="enabled">
                                <option value="1">true</option>
                                <option value="0">false</option>
                            </select>
                        </div>

                        <div class="form-group">
                            {{ Form::label('role_id', 'Role:') }}
                            <select class="form-control" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="save-user">Save user</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <!-- Modal Upload CSV-->
    <div id="uploadCSV" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                {!! Form::open(['route' => 'import.csv', 'method' => 'post',  'files' => 'true']) !!}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload CSV</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        {{ Form::label('import_file', 'CSV file:') }}
                        {{ Form::file('import_file') }}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload CSV</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@endsection

@section('javascripts')
    <!--Validation-->
    {!! Html::script('/public/js/parsley.min.js') !!}

    <!--
    Ajax save user. Everything works: Change type of button. Some difficulties with validation.
    <script>
    $(document).ready(function() {
        $("#save-user").click(function(){

            var data = $( "#new-user" ).serialize();

            $.ajax({
                url: '{ route("save.user") }',
                method: 'POST',
                data: data,
            })
            .done(function(data){
                if (data.length > 0){
                    $("#users-table").append(data);
                    $('#myModal').modal('hide');
                    $('#new-user').trigger( 'reset' );
                }
                else{

                }
            });

        });
    });
    </script>-->
@endsection

