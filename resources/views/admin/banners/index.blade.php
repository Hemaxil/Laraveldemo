@extends('layouts.master')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading">Banner Details
      <a class="btn btn-primary glyphicon glyphicon-plus" href={{route('banners.create')}}></a>
      
      <a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
    </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
          @empty($banners)
        <h5>No Banners Found</h5>
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
              <h3 class="box-title">Banners</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                    <th><input type=checkbox id="head" class="checkbox"></th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tbody id="table_body">
          
              
                  @foreach($banners as $banner)
                  <tr>
                    <td><input type=checkbox class="checkbox" id={{$banner->id}}></td>
                    <td>{{$banner->title}}</td>
                    <td>{{$banner->content}}</td>
                    <td><img src="{{asset('storage/banners/'.$banner->image)}}" height=50 width=50></td>
              
                    <td class="status" style="cursor:pointer ;">
                      @if($banner->status==1)
                        <a class="status-1-{{$banner->id}}">Enabled</a>
                        <a class="status-0-{{$banner->id}}" hidden>Disabled</a>
                      @else
                        <a class="status-1-{{$banner->id}}" hidden>Enabled</a>
                        <a class="status-0-{{$banner->id}}">Disabled</a>
                      @endif
                    </td>
                    <td><a id='banner.{{$banner->id}}' href={{route('banners.edit',['banner'=>$banner->id])}} class="btn btn-primary glyphicon glyphicon-pencil" ></a>
                    <i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$banner->id}}></i></a>
                    <form id='delete{{$banner->id}}' method="POST" action="{{route('banners.destroy',['banner'=>$banner->id])}}">
                      @method('DELETE')
                      @csrf
                    <input style="display:none;" type="submit" class="btn btn-danger">

                    </form></td>
                  </tr>
                  @endforeach
              
          
        </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                {{$banners->links()}}
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
  $(".delete_single").click(function(event){
    event.preventDefault();
    yes_del=confirm("Do you want to delete?");
    if(yes_del==1){
      $("#delete"+this.id).submit();
    }});
  delete_btn('{{route('banners.destroy_all')}}');
  update_status('{{route('banners.update_status')}}');
  $(".breadcrumb").append('<li class="active"><a href="{{route('banners.index')}}">Banners</a></li>');
</script>
  
@endsection

