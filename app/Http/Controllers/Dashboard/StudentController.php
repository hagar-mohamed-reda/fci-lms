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
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

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

    public function getData() {
        $query = Student::query();
        //$course = Subject::find(request()->course_id);

        return FacadesDataTables::eloquent($query->latest())
                        ->addColumn('action', function(Student $student) {
                            $type = "action";
                            return view("dashboard.students.action", compact("student", "type"));
                        })
                        ->editColumn('level_id', function(Student $student) {
                            return optional($student->level)->name;
                        })
                        ->editColumn('department_id', function(Student $student) {
                            return optional($student->department)->name;
                        })
                        ->editColumn('active', function(Student $student) {
                            $type = "active";
                            return view("dashboard.students.action", compact("student", "type"));
                        })
                        ->editColumn('account_confirm', function(Student $student) {
                            $type = "account_confirm";
                            return view("dashboard.students.action", compact("student", "type"));
                        })
                        ->rawColumns(['action', 'active', 'account_confirm'])
                        ->toJson();
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

    public function get_by_level(Request $request)
    {
        //abort_unless(\Gate::allows('city_access'), 401);

        if (!$request->level_id) {
            $html = '<option value="">'.trans('site.departments').'</option>';
        } else {
            $html = '';
            // $subjects = Subject::where('doc_id', $request->doc_id)->get();
            $departments = Department::where('level_id', $request->level_id)->get();
            foreach ($departments as $department) {
                $html .= '<option value="'.$department->level_id.'">'.$department->name.'</option>';
            }
        }

        return response()->json(['html' => $html]);
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
        //add doctor to user table
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'type'  =>  'student',
            'active' => 'required',

            'password' => 'required|confirmed',

            'level_id' => 'required',
            'department_id' => 'nullable',
            'code' => 'required||unique:students',
            'national_id' => 'required',
            'set_number' => 'required',
            'account_confirm' => 'required',
            //'permissions' => 'required|min:1',

        ]);
        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['type'] = 'student';
        //$request_data['fid']  = $student->id;
        if ($request_data['active'] == 'on' || $request_data['active'] == 1)
            $request_data['active'] = 1;
        else
        $request_data['active'] = 0;


        $user = User::create($request_data);
        $user->attachRole('student');
        //$user->syncPermissions($request->permissions);

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
        $user->update(['fid'=>$student->id]);
        //$student->syncPermissions($request->permissions);




        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.students.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApi(Request $request)
    {
        //add doctor to user table
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'active' => 'required',

            'password' => 'required|confirmed',
            //'permissions' => 'required|min:1',

        ]);
        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['type'] = 'student';
        //$request_data['fid']  = $student->id;


        $user = User::create($request_data);
        $user->attachRole('student');
        //$user->syncPermissions($request->permissions);

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

        if ($request_data['active'] == 'on' || $request_data['active'] == 1)
            $request_data['active'] = 1;
        else
        $request_data['active'] = 0;



        $student = Student::create($request_data);
        $student->attachRole('student');
        $user->update(['fid'=>$student->id]);

        //$student->syncPermissions($request->permissions);


        return [
            "status" => 0,
            "message" => __('site.added_successfully')
        ];
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

        if ($request_data['active'] == 'on' || $request_data['active'] == 1)
            $request_data['active'] = 1;
        else
            $request_data['active'] = 0;

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function updateApi(Request $request, Student $student)
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
        $user = $student->user;

        //update student in user table
        $request->validate([
            'name' => 'required',
            //'last_name' => 'required',
            'email' => 'required',
            //'username' => 'required|unique:users',
            'phone' => 'required',
            'active' => 'required',

        ]);

        $request_data= $request->except(['permissions']);
        optional($student->user)->update($request_data);


        return [
            "status" => 0,
            "message" => __('site.updated_successfully')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if ($student->stdAssign()->exists())
            {
                notify()->error(trans('site.can_not_delete_related_items'),"Error","topRight");
                return redirect()->route('dashboard.students.index');

            }else{
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
    }

    //change active function
    public function changeActive(Request $request,$id){
        $std = Student::find($id);

        $std->update([
            "active" => $request->active
        ]);

        $user = User::where('fid',$id);

        $user->update([
            "active" => $request->active
        ]);

       /* if($error->fails()){
            return response()->json(['errors' => $error->errors()->all()]);
        }*/

        return response()->json(['success'=>'Data Updated Succefully']);

        //return [1, "done"];
    }
}
