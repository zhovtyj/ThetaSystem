@extends('main')

@section('title', 'Entries')

@section('content')
    <div class="container">

        <div class="row">
            <div class="page-header">
                <h1>Entries</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                {!! Form::model($entry, ['route' => ['status.update', $entry->link], 'method' => 'put']) !!}

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
                            <th></th>
                        </tr>

                        <tr>
                            <td>{{ $entry->name }}</td>
                            <td><a href="callto:{{ $entry->phone }}">{{ $entry->phone }}</a></td>
                            <td>{{ $entry->user->name }}</td>
                            <td><a href="{{ $entry->link }}">{{ $entry->link }}</a></td>
                            <td>@if($entry->modified_count)  {{$entry->modified_count}} @else 0 @endif</td>
                            <td>
                                <select class="form-control status" name="status_id" id="{{ $entry->id }}">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" @if($status->id == $entry->status->id) selected="selected" @endif>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{ $entry->updated_at }}</td>
                            <td>{{ $entry->created_at }}</td>
                            <td><button type="submit" class="btn btn-success">Submit</button></td>
                        </tr>

                    </table>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection