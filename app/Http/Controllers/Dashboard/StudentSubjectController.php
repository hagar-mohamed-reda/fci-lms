<?php

namespace App\Http\Controllers\Dashboard;
use App\Student;
use App\Subject;
use App\StudentSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Imports\StdSbjImport;
use App\Exports\StdSbjExport;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjects = Subject::all();
        $students = Student::all();

        $stdSubjects = StudentSubject::when($request->search, function ($q) use ($request){
            return $q->where('id', 'like', '%'. $request->search . '%');

        })->when($request->sbj_id, function ($q) use ($request){
          return $q->where('subject_id', 'like', '%'. $request->sbj_id . '%');

        })->latest()->get();

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
            'subject_id' => 'required',
            'student_id' => 'required',
        ]);

        $request_data = $request->all();

        StudentSubject::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.subjects.index');
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
