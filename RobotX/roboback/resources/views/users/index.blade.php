@extends ('layouts.app')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-body">

            <div class="panel-body">
              <p class="list-header">
                <span class="user-header">Users</span>
                <a href="{{ route('users.create') }}" class="btn btn-default align-right">
                    <i class="fa fa-plus action-icon" title="New User"></i>
                </a>
              </p>

              <div class="form-group">

            <table class="table table-striped">
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Created at</th>
                  </tr>
                @if(!$users->count())
                  <tr>
                    <td colspan="4">No Users added yet.</td>
                  </tr>
                @endif

                @foreach($users as $user)
                <tr>
                    <td class="robot-actions">
                        <a href="{{ route('users.edit', $user->id) }}">
                            <i class="fa fa-pencil pull-left list-icon"></i>
                        </a>
                        <a href="{{ route('users.destroy', $user->id) }}" class="remove-confirm">
                            <i class="fa fa-trash pull-right list-icon"></i>
                        </a>
                        <a href="edit.blade.php"></a>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
