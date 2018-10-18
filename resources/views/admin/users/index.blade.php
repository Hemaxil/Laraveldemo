@extends('layouts.master')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading">Users Details
      <a class="btn btn-primary glyphicon glyphicon-plus" href={{route('users.create')}}></a>
      
      <a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
    </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
          @empty($users)
        <h5>No Users Found</h5>
      @endempty
      @if (count($errors) > 0)
          <div class="alert alert-danger">
          {{--  <strong>Whoops!</strong> There were some problems with your input.<br><br> --}}
            <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
          </div>
      @endif
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                    <th><input type=checkbox id="head" class="checkbox"></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tbody id="table_body">
          
              
                  @foreach($users as $user)
                  <tr>
                    <td><input type=checkbox class="checkbox" id={{$user->id}}></td>
                    <td>{{$user->firstname}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                      @foreach($user->getRoleNames() as $role)
                        <p class="btn btn-info">{{$role}}</p>
                      @endforeach</td>
                    <td class="status">
                      @if($user->status==1)
                        <a class="status-1-{{$user->id}}">Enabled</a>
                        <a class="status-0-{{$user->id}}" hidden>Disabled</a>
                      @else
                        <a class="status-1-{{$user->id}}" hidden>Enabled</a>
                        <a class="status-0-{{$user->id}}">Disabled</a>
                      @endif
                    </td>
                    <td><a id='user.{{$user->id}}' href={{route('users.edit',['user'=>$user->id])}} class="btn btn-primary glyphicon glyphicon-pencil" ></a></td>
                  </tr>
                  @endforeach
              
          
        </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                {{$users->links()}}
              </ul>
            </div>
          </div>
    </div>
    </div>
  </div>

   
@endsection

@section('additional_js')
<script type="text/javascript" src={{asset("js/roles.js")}}></script>
<script type="text/javascript">
  delete_btn('{{route('users.destroy')}}');
  update_status('{{route('users.update_status')}}');
  $(".breadcrumb").append('<li class="active"><a href="{{route('users.index')}}">Users</a></li>');
</script>
  
@endsection

