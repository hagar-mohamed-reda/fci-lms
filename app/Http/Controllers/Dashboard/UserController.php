<?php

namespace App\Http\Controllers\Dashboard;

use App\Admin;
use App\Doctor;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use SebastianBergmann\Environment\Console;
use Validator;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');

    }

    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->where(function($q) use ($request){

            return $q->when($request->search, function($query) use ($request){

                return $query->where('name', 'like', '%'. $request->search .'%')
                    ->orWhere('last_name', 'like', '%'. $request->search .'%');

            });
        })->latest()->paginate(4);

        return view('dashboard.users.index', compact('users'));

    }//end of index

    //change name function
    public function changeName(Request $request,$id){
        $user = User::find($id);
        $rules = array(
            'name' => 'required'
        );
        $request->validate([
            'name' => 'required',
        ]);

        $error = Validator::make($request->all(), $rules);

        if($error->fails()){
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name' => $request->name,
        );

        $user->update($form_data);

        //if user is doctor
        if($user->type == 'doctor'){
            $doc = Doctor::find($user->fid);
            $rules = array(
                'name' => 'required'
            );
            $request->validate([
                'name' => 'required',
            ]);
            $error = Validator::make($request->all(), $rules);
            if($error->fails()){
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'name' => $request->name,
            );
            $doc->update($form_data);
        }//end of if

        //if user is student
        if($user->type == 'student'){
            $std = Student::find($user->fid);
            $rules = array(
                'name' => 'required'
            );
            $request->validate([
                'name' => 'required',
            ]);
            $error = Validator::make($request->all(), $rules);
            if($error->fails()){
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'name' => $request->name,
            );
            $std->update($form_data);
        }//end of if

        //if user is admin
        if($user->type == 'admin'){
            $admin = Admin::find($user->fid);
            $rules = array(
                'name' => 'required'
            );
            $request->validate([
                'name' => 'required',
            ]);
            $error = Validator::make($request->all(), $rules);
            if($error->fails()){
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'name' => $request->name,
            );
            $admin->update($form_data);
        }//end of if

        //session()->flash('success', __('site.updated_successfully'));
        //return redirect()->route('dashboard.index');
        return response()->json(['success'=>'Data Updated Succefully']);

    }//end of change profile name function

    public function changePass(Request $request, $id){
        $user = User::find($id);
        $rules = array(
            'old_password' => 'required',
            'password' => 'required|confirmed',
        );
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $request_data = $request->except(['password', 'password_confirmation']);
        $request_data['password'] = bcrypt($request->password);

        $error = Validator::make($request->except(['password', 'password_confirmation']), $rules);

        if(Hash::check($request->old_password, $user->password) ){
            if($request->password == $request->password_confirmation){
                $user->update($request_data);
                return response()->json(['success'=>'Data Updated Succefully']);
            }else{
                return response()->json(['errors' => 'حقل التاكيد غير متطابق' ]);
            }
        }else{
            return response()->json(['errors' => 'the old password is false' ]);
         }
        if($error->fails()){
            return response()->json(['errors' => $error->errors()->all()]);
        }

        //if user is doctor
        if($user->type == 'doctor'){
            $doc = Doctor::find($user->fid);
            $rules = array(
                'old_password' => 'required',
                'password' => 'required|confirmed',
            );
            $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ]);

            $request_data = $request->except(['password', 'password_confirmation']);
            $request_data['password'] = bcrypt($request->password);

            $error = Validator::make($request->except(['password', 'password_confirmation']), $rules);

            if(Hash::check($request->old_password, $doc->password) ){
                if($request->password == $request->password_confirmation){
                    $doc->update($request_data);
                    return response()->json(['success'=>'Data Updated Succefully']);
                }else{
                    return response()->json(['errors' => 'حقل التاكيد غير متطابق' ]);
                }
            }else{
                return response()->json(['errors' => 'the old password is false' ]);
            }
            if($error->fails()){
                return response()->json(['errors' => $error->errors()->all()]);
            }
        }//end of doctor type

        //if user is student
        if($user->type == 'student'){
            $std = Student::find($user->fid);
            $rules = array(
                'old_password' => 'required',
                'password' => 'required|confirmed',
            );
            $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ]);

            $request_data = $request->except(['password', 'password_confirmation']);
            $request_data['password'] = bcrypt($request->password);

            $error = Validator::make($request->except(['password', 'password_confirmation']), $rules);

            if(Hash::check($request->old_password, $std->password) ){
                if($request->password == $request->password_confirmation){
                    $std->update($request_data);
                    return response()->json(['success'=>'Data Updated Succefully']);
                }else{
                    return response()->json(['errors' => 'حقل التاكيد غير متطابق' ]);
                }
            }else{
                return response()->json(['errors' => 'the old password is false' ]);
            }
            if($error->fails()){
                return response()->json(['errors' => $error->errors()->all()]);
            }
        }//end of student type

        //if user is admin
        if($user->type == 'admin'){
            $admin = Admin::find($user->fid);
            $rules = array(
                'old_password' => 'required',
                'password' => 'required|confirmed',
            );
            $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ]);

            $request_data = $request->except(['password', 'password_confirmation']);
            $request_data['password'] = bcrypt($request->password);

            $error = Validator::make($request->except(['password', 'password_confirmation']), $rules);

            if(Hash::check($request->old_password, $admin->password) ){
                if($request->password == $request->password_confirmation){
                    $admin->update($request_data);
                    return response()->json(['success'=>'Data Updated Succefully']);
                }else{
                    return response()->json(['errors' => 'حقل التاكيد غير متطابق' ]);
                }
            }else{
                return response()->json(['errors' => 'the old password is false' ]);
            }
            if($error->fails()){
                return response()->json(['errors' => $error->errors()->all()]);
            }
        }//end of admin type

    }//end of change password function

    //function to change profile phone
    public function changePhone(Request $request, $id){
        $user = User::find($id);
        $rules = array(
            'old_phone' => 'required',
            'new_phone' => 'required'
        );
        $request->validate([
            'old_phone' => 'required',
            'new_phone' => 'required'
        ]);

        $error = Validator::make($request->all(), $rules);

        if($error->fails()){
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if(! $user->phone == $request->old_phone){

         return response()->json(['errors' => 'the old phone is false' ]);
         }

         $form_data = array(
            'phone' => $request->new_phone,
        );
        $user->update($form_data);

         //if user is doctor
        if($user->type == 'doctor'){
            $doctor = Doctor::find($user->fid);

            $form_data = array(
                'phone' => $request->new_phone,
            );
            $doctor->update($form_data);

        }//end of doctor type
        return response()->json(['success'=>'Data Updated Succefully']);

    }//end of change profile phone function

    public function create()
    {
        return view('dashboard.users.create');
    }


    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            //'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'password' => 'required|confirmed',
        ]);

        $request_data= $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);

        $user = User::create($request_data);
        $user->attachRole('user');
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');

    }/* end of store */


    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            //'last_name' => 'required',
            'email' => 'required',
        ]);

        $request_data= $request->except(['permissions']);
        $user->update($request_data);

        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');
    }


    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
