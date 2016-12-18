@extends('main')

@section('title', 'Reports')

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1>Reports</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filter</h3>
                    </div>
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="{{ $active_user }}"><a href="#filter-user" aria-controls="filter-user" role="tab" data-toggle="tab">User</a></li>
                            <li role="presentation" class="{{ $active_status }}"><a href="#filter-status" aria-controls="filter-status" role="tab" data-toggle="tab">Status</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane {{ $active_user }}" id="filter-user">

                                {!! Form::open(['method' => 'get']) !!}

                                    <div class="form-group">
                                        {{ Form::label('filter_id', 'Choose user:') }}
                                        <select class="form-control" name="filter_id">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if($filter_id == $user->id ) selected="selected" @endif>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="filter_name" value="user_id">
                                        <button type="submit" class="btn btn-primary">Filter entries</button>
                                        <a href="{{route('report')}}" class="btn btn-default">Reset filter</a>
                                    </div>

                                {!! Form::close() !!}

                            </div>

                            <div role="tabpanel" class="tab-pane {{ $active_status }}" id="filter-status">

                                {!! Form::open(['method' => 'get']) !!}

                                <div class="form-group">
                                    {{ Form::label('filter_id', 'Choose user:') }}
                                    <select class="form-control" name="filter_id">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" @if($filter_id == $status->id ) selected="selected" @endif>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="filter_name" value="status_id">
                                    <button type="submit" class="btn btn-primary">Filter entries</button>
                                    <a href="{{route('report')}}" class="btn btn-default">Reset filter</a>
                                </div>

                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                @if(isset($entries[0]))
                    <table class="table" id="users-table">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>User</th>
                            <th>Link</th>
                            <th>Modified count</th>
                            <th>Status</th>
                            <th>Modified at</th>
                            <th>Created at</th>
                        </tr>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td>{{ $entry->name }}</td>
                                    <td>{{ $entry->phone }}</td>
                                    <td>{{ $entry->user->name }}</td>
                                    <td><a href="{{ $entry->link }}">{{ $entry->link }}</a></td>
                                    <td>@if($entry->modified_count)  {{$entry->modified_count}} @else 0 @endif</td>
                                    <td>
                                        <select class="form-control status" name="status_id" id="{{ $entry->id }}">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" @if($status->id == $entry->status_id) selected="selected" @endif>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $entry->updated_at }}</td>
                                    <td>{{ $entry->created_at }}</td>

                                </tr>
                            @endforeach
                    </table>
                @else
                    <div class="alert alert-warning" role="alert">No results</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select.status').on('change', function() {

                var entry_id = $(this).attr("id");
                var status_id = this.value;
                var token = '{{ Session::token() }}';

                $.ajax({
                    url: '{{ route("change.status") }}',
                    method: 'POST',
                    data: { entry_id:entry_id, status_id:status_id, _token:token },
                    success: function() {
                        console.log(entry_id+' '+status_id+' Changed successfully');

                    }
                })
            });
        });
    </script>
@endsection

