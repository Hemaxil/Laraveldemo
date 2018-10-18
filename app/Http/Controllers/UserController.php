<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Role as Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(10);
        return view('admin.users.index',['page_header'=>'Users','page_desc'=>'Home','title'=>'Users'])->with('users',$users);
            }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        
        return view('admin.users.create',['page_header'=>'Users','page_desc'=>'Create','title'=>'Users'])->with('roles',$roles);   

         }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'firstname'=>'required|string|max:45',
            'lastname'=>'required|string|max:45',
            'email'=>'required|email|max:45',
            'password'=>'required|confirmed',
            'status'=>'required',
            'roles'=>'required',
        ]);
        $roles=$request->roles;
        $new_user=User::create(['firstname'=>$request->firstname,'lastname'=>$request->lastname,'email'=>$request->email,'password'=>Hash::make($request->password),'status'=>$request->status]);
        $new_user->save();
        foreach($roles as $role){
            $new_user->assignRole($role);
        }
       
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user=User::findOrFail($id);
        return view('admin.users.details',['page_header'=>'Users','page_desc'=>'Details','title'=>'Users','user'=>$user]);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        
        //$roles=User::with('roles')->get();   ......Here roles is the name of the relationship
        //$user_roles=$user->roles()->select('id','name')->get();
        $roles=Role::all();
        return view('admin.users.edit',['page_header'=>'Users','page_desc'=>'Edit User','title'=>'Users'])->with(['user'=>$user,'roles'=>$roles,]);
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
        $user=User::findOrFail($id);
        $request->validate([
            'firstname'=>'required|string|max:45',
            'lastname'=>'required|string|max:45',
            'email'=>'required|email|max:45',
            'password'=>'required|confirmed',
            'status'=>'required',
            'roles'=>'required',]);

        $user->fill(['firstname'=>$request->firstname,'lastname'=>$request->lastname,'email'=>$request->email,'password'=>Hash::make($request->password),'status'=>$request->status]);
        $user->save();
        $user->syncRoles($request->roles);
        return redirect()->route('users.index');    }

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
        User::destroy($ids);

        $ids =json_encode($ids); 
        return($ids) ;
    }



    public function update_status(Request $request){

        $user=User::findOrFail($request->id);
        $status=($user->status==1) ? '0' :'1';

        $user->status=$status;
        $user->save();
        echo json_encode([$request->id,$status]);

    }

     public function destroy($id)
    {
       
        User::destroy($id);
        return redirect()->route('users.index');
    }
}
