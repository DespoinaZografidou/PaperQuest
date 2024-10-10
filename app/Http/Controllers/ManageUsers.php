<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ManageUsers extends Controller
{
    public function __construct()
    {
        //  Middleware that checks if there request comes from a logged in user
        $this->middleware('auth');
        //  Middleware that checks if the user is an admin and has active account
        $this->middleware('checkRoleAndStatus:Admin');
    }

    // Function that returns the user
    // This is only for the Admins of the system
    public function ShowUsers(){
        $data=User::where('system_role', 'User')->paginate(8);
        $title='User';

        return view('admin/manageUsers',['users'=>$data,'title'=>$title]);

    }

    // Function that returns the Admins
    // This is only for the Admins of the system
    public function ShowAdmins(){
        $data=User::where('system_role', 'Admin')->paginate(8);
        $title='Admin';

        return view('admin/manageUsers',['users'=>$data,'title'=>$title]);

    }

    // Function that returns the Membership Requests and Delete Requests
    // This is only for the Admins of the system
    public function Requests(){
        $data=User::where('system_role', NULL)->orderBy('created_at', 'desc')->paginate(8);
        $title='Request';

        return view('admin/manageUsers',['users'=>$data,'title'=>$title]);

    }

    // Function that allows the admin to update the role and the account status of a user
    public function UpdateUser(Request $request)
    {
        $id=$request->input('id');
        $system_role=$request->input('role');
        $account_status=$request->input('status');

        if($request->file('image')!=null){
            $image = $request->file('image');
            $filename = time() . '_' .$image->getClientOriginalName();
            // Move the uploaded file to a desired directory
            $image->move(public_path('profile_pictures'), $filename);

            User::where('id',$id)->update([
                'system_role'=>$system_role,
                'account_status'=>$account_status,
                'profile_picture'=>'profile_pictures/'.$filename
            ]);

        }else{
            User::where('id',$id)->update([
                'system_role'=>$system_role,
                'account_status'=>$account_status
            ]);
        }


        return redirect()->back()->with('message',"The user has been successfully updated!");
    }


    //Function that returns only the unlocked accounts of a specific type of users( Users, Admins or not defined )
    public function ShowTypeOfUsers_Unlocked($title){
        $type=$title;
        if($type=='Request'){
            $type=null;
        }
        $data = User::where('system_role', $type)
            ->where('account_status', 1)
            ->paginate(8);


        return view('admin/manageUsers',['users'=>$data,'title'=>$title,'stat_b'=>1]);
    }

    //Function that returns only the locked accounts of a specific type of users( Users, Admins or not defined )
    public function ShowTypeOfUsers_Locked($title){
        $type=$title;
        if($type=='Request'){
            $type=null;
        }

        $data = User::where('system_role', $type)
            ->where('account_status', 0)
            ->paginate(8);


        return view('admin/manageUsers',['users'=>$data,'title'=>$title,'stat_b'=>0]);
    }

    // Function for searching Users by name or email
    public function SearchUser(Request $request,$title){
        $key=$request->input("key");
        $type=$title;
        $data=[];
        if($type=='Request'){
            $type=null;
        }
        if($key==null){
            $data=User::where('system_role',$type)->paginate(8);
        }else{
            $data = User::where('system_role', $type)
                ->where(function ($query) use ($key) {
                    $query->where('email', 'like', '%' . $key . '%')
                        ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ['%' . $key . '%'])
                        ->orWhereRaw("CONCAT(lastname, ' ', firstname) like ?", ['%' . $key . '%']);
                })->paginate(8);

        }

        return view('admin/manageUsers',['users'=>$data,'title'=>$title]);
    }

    //Function for deleting a user's account
    public function DeleteUser(Request $request){
        $id=$request->input('id');
        User::where('id',$id)->delete();
        return redirect()->back();
    }

}
