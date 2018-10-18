<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration as Configuration;
class ConfigurationController extends Controller
{

/*    public function __construct(){
        $this->configurations='App\Configuration'::all();
    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configurations='App\Configuration'::with('created_by_user','modified_by_user')->paginate(10);

        return view('admin.configurations.index',['page_header'=>'Configurations','page_desc'=>'Details','title'=>'Configurations','configurations'=>$configurations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.configurations.create',['page_header'=>'Configurations','page_desc'=>'Create','title'=>'Configurations']);
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
            'conf_key'=>'required|max:45|string',
            'conf_value'=>'required|max:100|string',
            'status'=>'required'
        ]);
        
        $configuration='App\Configuration'::create(['conf_key'=>$request->conf_key,'conf_value'=>$request->conf_value,'created_by'=>$request->user()->id,'modified_by'=>$request->user()->id,'status'=>$request->status]);

        $configuration->save();
        
        return redirect()->route('configurations.index');

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
        $configuration=Configuration::findOrFail($id);
      
        return view('admin.configurations.edit',['page_header'=>'Configurations','page_desc'=>'Edit','title'=>'Cnfigurations','configuration'=>$configuration]);
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
            'conf_key'=>'required|max:45',
            'conf_value'=>'required|max:100',
            'status'=>'required'
        ]);
        $configuration=Configuration::findOrFail($id);
        $configuration->fill(['conf_key'=>$request->conf_key,'conf_value'=>$request->conf_value,'modified_by'=>$request->user()->id,'status'=>$request->status]);
        $configuration->save();
        return redirect()->route('configurations.index');

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
        //Configuration::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }



    public function update_status(Request $request){

        $configuration=Configuration::findOrFail($request->id);
        $status=($configuration->status==1) ? '0' :'1';

        $configuration->status=$status;
        $configuration->save();
        echo json_encode([$request->id,$status]);

    }

    public function destroy($id)
    {
       
        Configuration::destroy($id);
        return redirect()->route('configurations.index');
    }
}
