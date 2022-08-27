@include('layout.header')
<div class="row">
    <div class="col card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">List User</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Role User</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if ($user->role_id == 1)
                                    Admin
                                @else
                                    User
                                       
                              <form action="{{url('/admin/user')}}" method="post">
                              @csrf
                              @method('patch')
                              <input type="hidden" name="user_id" value="{{$user->id}}">
                              <button type="submit" class="badge badge-success">promote</button>
                              </form>
                                @endIf
                            </td>
                            <th>
                            @if ($user->id != 1 && Auth::id() != $user->id)
                                
                              <form action="{{url('/admin/user')}}" method="post">
                              @csrf
                              @method('delete')
                              <input type="hidden" name="user_id" value="{{$user->id}}">
                              <button type="submit" class="btn btn-danger">delete</button>
                              </form>
                            @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('layout.footer')
