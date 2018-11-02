@extends('layouts.master')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading">Order Details
      <a id="delete_btn" class="btn btn-danger glyphicon glyphicon-trash"></a>
    </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
          @empty($orders)
        <h5>No Orders Found</h5>
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

      @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
          {{Session::get('success')}}

        </div>
      @endif
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Orders</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                    <th><input type=checkbox id="head" class="checkbox"></th>
                    <th>Order Id</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tbody id="table_body">
          
              
                  @foreach($orders as $order)
                  <tr>
                    <td><input type=checkbox class="checkbox" id={{$order->id}}></td>
                    <td>{{$order->id}}</td>
                    <td>@if($order->payment_gateway_id==1) COD @else Paypal @endif</td>
                    <td>{{$order->grand_total}}</td>
                    <td class="status-{{$order->id}}" style="cursor:pointer ;">
                        <a class="{{$order->status}}-{{$order->id}}">{{$order->status}}</a>
                    </td>
                    <td>{{-- <a id='order.{{$order->id}}' href={{route('orders.edit',['order'=>$order->id])}} class="btn btn-primary glyphicon glyphicon-pencil" ></a> --}}
                    <a><i class="delete_single btn btn-danger glyphicon glyphicon-trash" id={{$order->id}}></i></a>
                    <form id='delete{{$order->id}}' method="POST" action="{{route('orders.destroy',['order'=>$order->id])}}">
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
                {{$orders->links()}}
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
  delete_btn('{{route('orders.destroy_all')}}');
 $(document).on('click',"td[class*='status-'] a",function(event){
  event.preventDefault();
  var status=(this.className).split('-')[0];
  var id=(this.className).split('-')[1];
  
  $.ajax({
    url:'{{route('orders.update_status')}}',
    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    data:{'id':id,'status':status},
    dataType:'json',
    type: "patch",
   }).done(function(result){
    console.log(result,"status-"+result[0]);
      $(".status-"+result[0]).children().remove();
      $(".status-"+result[0]).append("<a class='"+result[1]+"-"+result[0]+"'>"+result[1]+"</a>");
      if(result[1]=='delivered'){
        $(".status-"+result[0]+"a").attr('hidden',true);
      }
   });

 })
  $(".breadcrumb").append('<li class="active"><a href="{{route('orders.index')}}">Banners</a></li>');
</script>
  
@endsection

