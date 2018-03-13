@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p class="list-header">
                            <span class="icon-header">Icons</span>
                            <a href="{{ route('icons.create') }}" class="btn btn-default align-right">
                                <i class="fa fa-plus action-icon" title="New Icon"></i>
                            </a>
                        </p>

                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                            </tr>
                            @if(!$icons->count())
                                <tr>
                                    <td colspan="4">No icons added yet.</td>
                                </tr>
                            @endif

                            @foreach ($icons as $icon)
                                <tr>
                                    <td class="icon-actions">
                                        <a href="{{ route('icons.edit', $icon->id) }}">
                                            <i class="fa fa-pencil pull-left list-icon"></i>
                                        </a>
                                        <a href="{{ route('icons.destroy', $icon->id) }}" class="remove-confirm">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                        <a href="edit.blade.php"></a>
                                    </td>
                                    <td><img class="pull-left list-icon icon-icon" src="{{ 'data:image/' . $icon->type . ';base64,' . $icon->icon }}"/></td>
                                    <td>{{ $icon->name }}</td>
                                    <td>{{ $icon->description }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection