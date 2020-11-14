<?php

namespace App\Http\Controllers\Dashboard;

use App\Assignment;
use App\Doctor;
use App\StudentAssignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Student;
use App\Subject;

class StudentAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $assignments = Assignment::all();
        $students = Student::all();
        $doctors = Doctor::all();

        $subjects = Subject::all();
        $lessons = Lesson::all();

        $stdAssignments = StudentAssignment::when($request->search, function ($q) use ($request){
            return $q->where('id', 'like', '%'. $request->search . '%');

        })->when($request->assign_id, function ($q) use ($request){
          return $q->where('assign_id', 'like', '%'. $request->assign_id . '%');

        })->when($request->lesson_id, function ($q) use ($request){
            return $q->where('lesson_id', 'like', '%'. $request->lesson_id . '%');

          })->when($request->sbj_id, function ($q) use ($request){
              return $q->where('sbj_id', 'like', '%'. $request->sbj_id . '%');

            })->when($request->doc_id, function ($q) use ($request){
                return $q->where('doc_id', 'like', '%'. $request->doc_id . '%');

                })->latest()->get();

        return view('dashboard.student_assignments.index', compact('assignments','stdAssignments', 'students', 'subjects', 'lessons', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignments = Assignment::all();
        $students = Student::all();

        return view('dashboard.student_assignments.create', compact('assignments', 'students'));
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
            'student_id' => 'required',
            'assign_id' => 'required',
            'pdf_anss'  => 'required',
            'lesson_id' => 'required',
            'sbj_id' => 'required',
            'doc_id'  => 'required'
        ]);
        $request_data = $request->except('pdf_anss');

        if($request->hasFile('pdf_anss')){
            $pdf_anss = $request->file('pdf_anss');
            $filename=time().'.'.$pdf_anss->getClientOriginalExtension();
            $destinationPath = public_path('uploads/anssers');
            $request_data['pdf_anss'] = $filename;

            $pdf_anss->move($destinationPath,$filename);
            //dd($pdf_quest);
        }

        StudentAssignment::create($request_data);


        session()->flash('success', __('site.uploaded_successfully'));
        return redirect()->route('dashboard.assignments.index');

    }

    public function show_pdf($id)
    {
        $data = StudentAssignment::find($id);
        return view('dashboard.student_assignments.pdf_details', compact('data'));
    }
    //function to download pdf file
    public function download_pdf($pdf_anss){
        return response()->download('uploads/anssers/'.$pdf_anss);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentAssignment  $studentAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAssignment $studentAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentAssignment  $studentAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAssignment $studentAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentAssignment  $studentAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentAssignment $studentAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentAssignment  $studentAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAssignment $studentAssignment)
    {
        //
    }
}
