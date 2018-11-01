@extends('layouts.master')
@section('content')
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
 <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$new_orders}}</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fa "></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$total_orders}}<sup style="font-size: 20px"></sup></h3>
              <p>Total Orders</p>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('pdf_orders')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$new_users}}</h3>

              <p>New Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('pdf_users')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$total_sales}}</h3>

              <p>Total Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">{{-- More info  --}}<i class="fa "></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">
          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Sales Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
         
          </div>
      

        </section>
        <section class="col-lg-6 connectedSortable">
          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Orders Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="orders-chart" style="height: 250px;"></div>
            </div>

         
          </div>
      

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
      <div class="row">
        
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Orders</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Item</th>
                    <th>Status</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                 
                    @foreach($all_orders as $order)
                    <tr>
                    <td><a href="pages/examples/invoice.html">{{$order->id}}</a></td>
                    <td>@foreach($order->get_order_details as $detail)
                      {{$detail->get_product_details->name}}&nbsp; 
                    @endforeach</td>
                    <td><span class="label label-success">{{$order->status}}</span></td>
                   
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
          {{--   <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> --}}
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        


      </div>
        

    </section>
    
	
@endsection
@section('additional_js')
<script type="text/javascript">
	
  $.ajax({
    url:'{{route('sales_data')}}',
    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    type: "get",
    dataType:'json',
  }).done(function(result){
    // console.log(result);
    $sales_graph=[];
    var objstr = "[";
   

   /* $.each(result[0],function(key,value){
     
      // $item={};
      // $item['Month']=key;
      // $item['Sales']=value;
      // $sales_graph.push($item);
      objstr += "{Month : '" + key + "', Sales:'" + value + "'},";



    });
    objstr+="]";*/
  console.log(result);
    $orders_graph=[];
    /*$.each(result[1],function(key,value){
     
      $item={};
      $item['Month']=key;
      $item['Orders']=value;
      $orders_graph.push($item);


    })*/
   // var abc=JSON.parse(JSON.stringify([{"mobile":10,"age":"36"},{"mobile":20,"age":"10"}]));
    //console.log(abc);
    // return false;
console.log(JSON.parse(result[1]))
//    return false;
    var sales = new Morris.Line({
    element          : 'line-chart',
    resize           : true,
    data             :JSON.parse(result[0]),
    xkey             : 'Month',
    ykeys            : ['Sales'],
    labels           : ['Sales'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  });

    console.log('sales');
   // return false;
    var orders = new Morris.Line({
    element          : 'orders-chart',
    resize           : true,
    data             : JSON.parse(result[1]),
    xkey             : 'Month',
    ykeys            : ['Orders'],
    labels           : ['Orders'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  });

  $('.box ul.nav a').on('shown.bs.tab', function () {
      sales.redraw();
      //orders.redraw();
  });
  })

  
	

</script>
@endsection
