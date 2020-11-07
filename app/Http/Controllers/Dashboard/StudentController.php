<?php

namespace App\Http\Controllers\Dashboard;

use App\Department;
use App\Exports\StudentsExport;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Level;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_students'])->only('index');
        $this->middleware(['permission:create_students'])->only('create');
        $this->middleware(['permission:update_students'])->only('edit');
        $this->middleware(['permission:delete_students'])->only('destroy');

    }

    public function importExportView()
    {
       return view('dashboard.students.index');
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function import()
    {
        Excel::import(new StudentsImport,request()->file('file'));

        return back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = Student::when($request->search, function ($q) use ($request){
            return $q->where('name', 'like', '%'. $request->search . '%')
                    ->orWhere('code', 'like', '%'. $request->search . '%');
        })->get();
        return view('dashboard.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::all();
        $departments = Department::all();

        return view('dashboard.students.create', compact('levels', 'departments'));
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
            'name' => 'required',
            'level_id' => 'required',
            'department_id' => 'nullable',
            'code' => 'required||unique:students',
            'email' => 'required|unique:students',
            'username' => 'required|unique:students',
            'phone' => 'required|unique:students',
            'active' => 'required',
            'account_confirm' => 'required',
            'national_id' => 'required',
            'set_number' => 'required',

            'password' => 'required|confirmed',
            //'permissions' => 'required|min:1',

        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);


        $student = Student::create($request_data);
        $student->attachRole('student');
        //$student->syncPermissions($request->permissions);

        //add doctor to user table
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'type'  =>  'student',
            'active' => 'required',

            'password' => 'required|confirmed',
            //'permissions' => 'required|min:1',

        ]);
        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['type'] = 'student';
        $request_data['fid']  = $student->id;


        $user = User::create($request_data);
        $user->attachRole('student');
        //$user->syncPermissions($request->permissions);


        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.students.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $levels = Level::all();
        $departments = Department::all();
        return view('dashboard.students.edit', compact('student','levels', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student, User $user)
    {
        $request->validate([
            'name' => 'required',
            'level_id' => 'required',
            'department_id' => 'required',
            'code' => ['required', Rule::unique('students')->ignore($student->id)],
            'email' => ['required', Rule::unique('students')->ignore($student->id)],
            'username' => ['required', Rule::unique('students')->ignore($student->id)],
            'phone' => ['required', Rule::unique('students')->ignore($student->id)],
            'national_id' => 'required',
            'set_number' => 'required',
            'active' => 'required',

        ]);

        $request_data = $request->except(['permissions']);
        //$request_data['phone'] = array_filter($request->phone);

        $student->update($request_data);

        //update student in user table
        $request->validate([
            'name' => 'required',
            //'last_name' => 'required',
            'email' => 'required',
            //'username' => 'required|unique:users',
            'phone' => 'required',
            'active' => 'required',

        ]);

        $users = User::all();
        foreach ($users as $user) {
            if($user->fid == $student->id && $user->type == 'student'){
                $request_data= $request->except(['permissions']);
                $user->update($request_data);
            }
        }


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->fid == $student->id){
                $user->delete();
            }
        }

        $student->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.students.index');
    }

    //change active function
    public function changeActive(Request $request,$id){
        $std = Student::find($id);

        $form_data = array(
            'active' => $request->active,
        );
        $std->update($form_data);
    }
}
