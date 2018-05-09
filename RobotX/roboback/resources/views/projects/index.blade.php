@extends('layouts.app')

@section('content')

    <div class="container">
        <div id="row">
            <div class="col-md-12">
                @if (!Auth::guest())
                    <p class="project-header">
                        <a href="{{ route('projects.create') }}" class="btn btn-default align-right">
                            <i class="fa fa-plus list-icon" title=" Add project"></i>
                        </a>
                    </p>
                @endif
            </div>
        </div>
        <div class="panel-group" id="accordion">
            <div id="row">
                @foreach($projects as $project)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            @if (!Auth::guest())
                                <a href="{{ route('projects.edit', $project->id) }}">
                                    <img src="{{ $project->getImage() }}" class="project-image" alt="Project image" title="{{ $project->name }}">
                                </a>
                            @else
                                <img src="{{ $project->getImage() }}" class="project-image" alt="Project image" title="{{ $project->name }}">
                            @endif
                            <div class="caption">
                                <h4>{{ $project->name }}</h4>
                                <p><i class="fa fa-clock-o" class="project-date"></i> {{ date('d-m-Y H:i', strtotime($project->start_time)) }}</p>
                                @if (!Auth::guest())
                                    <p>
                                        {{ Form::open(['route' => ['projects.destroy', $project->id], 'method' => 'delete', 'style' => 'display: inline']) }}
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary" role="button" title="Edit"><i class="fa fa-pencil project-action-icon"></i></a>
                                            <a href="{{ route('projects.copy', $project->id) }}" class="btn btn-default" role="button" title="Copy"><i class="fa fa-copy project-action-icon"></i></a>
                                            @if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2)
                                            <button type="submit" class="btn btn-default" role="button" title="Delete"><i class="fa fa-trash project-action-icon"></i></button>
                                            @endif
                                        {{ Form::close() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection