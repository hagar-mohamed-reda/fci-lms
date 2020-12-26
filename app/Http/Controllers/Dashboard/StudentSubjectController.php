<?php

namespace App\Http\Controllers\Dashboard;
use App\Student;
use App\Subject;
use App\StudentSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use App\Imports\StdSbjImport;
use App\Exports\StdSbjExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class StudentSubjectController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_regist'])->only('index');
        $this->middleware(['permission:create_regist'])->only('create');
        $this->middleware(['permission:update_regist'])->only('edit');
        $this->middleware(['permission:delete_regist'])->only('destroy');

    }

    public function importExportView()
    {
       return view('dashboard.student_subjects.index');
    }

    public function export()
    {
        return Excel::download(new StdSbjExport, 'studentSubjects.xlsx');
    }

    public function import()
    {
        Excel::import(new StdSbjImport,request()->file('file'));

        return back();
    }

    public function getData(Request $request) {
        $query = StudentSubject::query();

        if (Auth::user()->type == 'doctor')
            $query->whereIn('course_id', Auth::user()->toDoctor()->docSubjs()->pluck('course_id')->toArray());

        if ($request->course_id > 0)
            $query->where('course_id', request()->course_id)
                    ->orWhere('course_id', 'like', '%'. $request->course_id . '%');


        return FacadesDataTables::eloquent($query->latest())
                        ->addColumn('action', function(StudentSubject $stdSubject) {
                            return view("dashboard.student_subjects.action", compact("stdSubject"));
                        })
                        ->addColumn('student', function(StudentSubject $stdSubject) {
                            return optional($stdSubject->students)->name;
                        })
                        ->addColumn('course', function(StudentSubject $stdSubject) {
                            return optional($stdSubject->subjects)->name;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjects = Subject::all();
        $students = Student::all();

        $query = StudentSubject::query();

        if ($request->search)
            $query->where('name', 'like', '%'. $request->search . '%');

        if ($request->assign_id > 0)
            $query->where('assign_id', 'like', '%'. $request->assign_id . '%');

        if ($request->course_id > 0)
            $query->where('course_id', 'like', '%'. $request->course_id . '%');

        if ($request->lesson_id > 0)
            $query->where('lesson_id', 'like', '%'. $request->lesson_id . '%');

        if ($request->doc_id > 0)
            $query->where('doc_id', 'like', '%'. $request->doc_id . '%');

        $stdSubjects = $query->latest()->get();


        /*$stdSubjects = StudentSubject::when($request->search, function ($q) use ($request){
            return $q->where('id', 'like', '%'. $request->search . '%');

        })->when($request->sbj_id, function ($q) use ($request){
          return $q->where('course_id', 'like', '%'. $request->sbj_id . '%');

        })->latest()->get();*/

        return view('dashboard.student_subjects.index', compact('subjects','stdSubjects', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        $students = Student::all();

        return view('dashboard.student_subjects.create', compact('subjects', 'students'));
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
            'course_id' => 'required',
            'student_id' => 'required',
        ]);


        if(StudentSubject::where('student_id','=', $request->student_id)
                    ->where('course_id', '=', $request->course_id)
                    ->exists()
        ){
            notify()->error(trans('site.this_student_already_exists'),"Error","topRight");
            return redirect()->back();
            //return redirect()->route('dashboard.students.index');
        }else{
            $request_data = $request->all();

            StudentSubject::create($request_data);

            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.subjects.index');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentSubject  $studentSubject
     * @return \Illuminate\Http\Response
     */
    public function show(StudentSubject $studentSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentSubject  $studentSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentSubject $studentSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentSubject  $studentSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentSubject $studentSubject)
    {
        //
    }

    /**
     * return all student for register course
     *
     */
    public function getStudents() {
        $query = Student::query();
        $course = Subject::find(request()->course_id);

        return FacadesDataTables::eloquent($query)
                        ->addColumn('action', function(Student $student) use ($course) {
                            return view("dashboard.subjects.student_register_action", compact("student", "course"));
                        })
                        ->addColumn('level', function(Student $student) {
                            return optional($student->level)->name;
                        })
                        ->addColumn('department', function(Student $student) {
                            return optional($student->department)->name;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }

    /**
     * assign doctor view.
     *
     * @return \Illuminate\Http\Response
     */
    public function performAssign(Request $request)
    {
        $course = Subject::find($request->course_id);

        if (!$course)
            return [
                "status" => 0,
                "message" => __('error')
            ];

        // remove old
        $course->stdSbjs()->delete();

        // add new
        $counter = 0;
        foreach($request->student_id as $student) {
            if ($request->assign[$counter] == 1) {
                StudentSubject::create([
                    "course_id" => $course->id,
                    "student_id" => $student
                ]);
            }

            $counter ++;
        }

        return [
            "status" => 1,
            "message" => __('done')
        ];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentSubject  $studentSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentSubject $studentSubject)
    {
        $studentSubject->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.student_subjects.index');
    }
}
