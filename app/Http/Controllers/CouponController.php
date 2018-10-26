<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon as Coupon;
use Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons=Coupon::paginate(10);
        return view('admin.coupons.index',['page_header'=>'Coupons','page_desc'=>'Details','title'=>'Coupons','coupons'=>$coupons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create',['page_header'=>'Coupons','page_desc'=>'Details','title'=>'Coupons']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|max:45|alpha_num',
            'percent_off'=>'required|regex:/^\d*.?\d{1,2}$/',
            'no_of_uses'=>'required|integer'
        ]);

        $coupon=Coupon::create(['code'=>$request->code,'percent_off'=>$request->percent_off,'no_of_uses'=>$request->no_of_uses,'created_by'=>$request->user()->id,'status'=>'0','modified_by'=>$request->user()->id]);
        $coupon->save();\
        Session::flash('success','Coupon created!!');
        return redirect()->route('coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon=Coupon::findOrFail($id);
        return view('admin.coupons.edit',['page_header'=>'Coupons','page_desc'=>'Edit','title'=>'Coupons','coupon'=>$coupon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required|max:45|alpha_num',
            'percent_off'=>'required|regex:/^\d*.?\d{1,2}$/',
            'no_of_uses'=>'required|integer'
        ]);
        $coupon=Coupon::findOrFail($id);
        $coupon->fill(['code'=>$request->code,'percent_off'=>$request->percent_off,'no_of_uses'=>$request->no_of_uses,'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id]);
        $coupon->save();
        Session::flash('success','Coupon updated!!');

        return redirect()->route('coupons.index');
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids=explode("+",$request->ids);
        $ids = array_filter($ids);
        //Coupon::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }



    public function update_status(Request $request){

        $coupon=Coupon::findOrFail($request->id);
        $status=($coupon->status==1) ? '0' :'1';

        $coupon->status=$status;
        $coupon->save();
        echo json_encode([$request->id,$status]);

    }
     public function destroy($id)
    {
       
        Coupon::destroy($id);
        Session::flash('success','Coupon deleted!!');

        return redirect()->route('coupons.index');
    }
}
