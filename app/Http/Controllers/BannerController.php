<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner as Banner;
use Image;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $banners=Banner::paginate(10);
        return view('admin.banners.index',['page_header'=>'Banners','page_desc'=>'Home','title'=>'Banners','banners'=>$banners]);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.banners.create',['page_header'=>'Banners','page_desc'=>'Create','title'=>'Banners']);   
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
            'title'=>'required',
            'image'=>'required',
            'status'=>'required'
        ]);
   
        $banner=new Banner;
        if(isset($request->title)){
            $banner->title=$request->title;
        }
        if(isset($request->content)){
            $banner->content=$request->content;
        }
        $path=$request->image->store('public/banners');
       
        
        $banner->image=explode('/',$path)[2];
        
         $thumb_img = Image::make($request->image)->resize(200,200);
         $thumb_img->save('public/banners/Small/'.$banner->image);
        $banner->status=$request->status;
        $banner->created_by=auth()->user()->id;
        $banner->modified_by=auth()->user()->id;
        $banner->save();

        return redirect()->route('banners.index');
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
        $banner=Banner::findOrFail($id);

        return view('admin.banners.edit',['page_header'=>'Banners','page_desc'=>'Edit','title'=>'Banners','banner'=>$banner]);
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
        $banner=Banner::findOrFail($id);
        $request->validate([
            'title'=>'required',
            'status'=>'required']);

        if($request->image!=null){
            $path=$request->image->store('public/banners');
          
            $banner->fill(['image'=>  explode('/',$path)[2]]);
        }
        $banner->fill(['title'=>$request->title,'status'=>$request->status,'modified_by'=>$request->user()->id]);
        $banner->save();

        return redirect()->route('banners.index');
        


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
        //Banner::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }



    public function update_status(Request $request){
        
        $banner=Banner::findOrFail($request->id);
        $status=($banner->status==1) ? '0' :'1';

        $banner->status=$status;
        $banner->save();
        echo json_encode([$request->id,$status]);

    }
}