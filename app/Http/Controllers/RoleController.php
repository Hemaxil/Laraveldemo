<?php

namespace App\Http\Controllers;
use App\Role as Role;
use Session;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Role::paginate(10);
       return view('roles.index',['title'=>'Roles','page_header'=>'Roles','page_desc'=>'Home'])->with('roles',$role); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create',['page_header'=>'Roles','page_desc'=>'Create']);
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
            'name'=>'required|max:10',
        ]);
        $role=Role::create(['name'=>$request->input('name'),'guard_name'=>'web']);
        //dd($role);
        $role->save();
        Session::flash('success','New Role created!!');
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $role=Role::findOrFail($id);
        return view('roles.edit',['page_header'=>'Roles','page_desc'=>'Edit Role'])->with('role',$role);
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
        $role=Role::findOrFail($id);
        $request->validate([
            'name'=>'required|max:10']);
        $role->fill(['name'=>$request->name]);
        $role->save();
        Session::flash('success','Role Updated!!');
        return redirect()->route('roles.index');
    }

    
     /*

    Delete multiple roles.
    Input :list of ids to be deleted
    Output:list of deleted ids 
    */

    public function delete(Request $request)
    {
        $ids=explode("+",$request->ids);
        $ids = array_filter($ids);
        Role::destroy($ids);
        $ids =json_encode($ids); 
        print($ids) ;

    }
    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */


     public function destroy($id)
    {
       
        Role::destroy($id);
        Session::flash('success','Role deleted');
        return redirect()->route('roles.index');
    }
}
