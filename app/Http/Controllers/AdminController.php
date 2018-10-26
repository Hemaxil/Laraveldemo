<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateInterval;
use Carbon\Carbon;
class AdminController extends Controller
{
   public function __construct(){

       $this->all_orders='App\UserOrder'::with('get_order_details.get_product_details')->whereDate('created_at','>',Carbon::today()->subYear(1)->toDateString())->orderBy('created_at','desc')->get();
   }

    public function index(){
    	$todays_date=Carbon::today();
    	//users created today
    	$new_users=count('App\User'::whereDate('created_at',$todays_date->toDateString())->get());
        $total_sales=0;
        

        // $days_sub=(now()->sub(new DateInterval('P30D')));
        // $date_30_days_ago=date_format($days_sub,'Y-m-d');
        //orders since last year
       

      //	todays orders
	    $new_orders=$this->all_orders->filter(function($key,$value){
	       		if($key->created_at->toDateString()==date('Y-m-d')){
	       			return $key;
	       		}
	    });
      
	    //orders this month
	    // $orders_this_month=$this->all_orders->filter(function($key,$value){
	    // 	if($key->created_at->toDateString()>Carbon::today()->subMonth(1)->toDateString()){
	    // 		return $key;
	    // 	}
	    // });


	    //yearly sales
   		$total_sales=($this->all_orders->pluck('grand_total')->sum());
   		//yearly orders
   		$total_orders=count($this->all_orders);


   		
        return view('admin.index',['page_header'=>'Dashboard','page_desc'=>'Control Panel','new_users'=>$new_users,'new_orders'=>count($new_orders),'total_sales'=>$total_sales,'total_orders'=>$total_orders,'all_orders'=>$this->all_orders->take(10)]);
    }


    public function get_sales_data(Request $request){

      $sales_graph=$this->all_orders->groupBy(function($item){
          return ($item->created_at->format('Y:m'));
        })->map(function($item,$key){
          return ($item->sum('grand_total'));
        });
      // $sales_array=[];
      //  foreach ($sales_graph as $key => $value) {
      //    array_push($sales_array, (['Month'=>$key,'Sales'=>$value]));
      //  }
       
          $sales_str="[";
        foreach($sales_graph as $key=>$value){

          if($sales_graph->last()==$value)
            $sales_str.='{"Month" : "' . $key . '", "Sales":"'.$value .'"}';
          else
            $sales_str.='{"Month": "' . $key . '", "Sales":"'.$value .'"},';
        }
          $sales_str.="]";
        $orders_graph=$this->all_orders->groupBy(function($item){
          return ($item->created_at->format('Y:m'));
        })->map(function($item,$key){
          return ($item->count());
        });
        $orders_str="[";
        foreach($orders_graph as $key=>$value){

          if($orders_graph->last()==$value)
            $orders_str.='{"Month" : "' . $key . '", "Orders":"'.$value .'"}';
          else
            $orders_str.='{"Month": "' . $key . '", "Orders":"'.$value .'"},';
        }
          $orders_str.="]";

       
       //  $orders_array=[];
       //  foreach ($orders_graph as $key => $value) {
       //   array_push($orders_array, (['Month'=>$key,'Orders'=>$value]));
       // }


      echo json_encode([$sales_str,$orders_str]);
    }

   

}
