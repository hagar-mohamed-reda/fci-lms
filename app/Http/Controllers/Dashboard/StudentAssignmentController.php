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
use Auth;

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

    /*
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
    */
    $stdAnss = [];
    if (Auth::user()->type == 'doctor')
            $stdAnss = StudentAssignment::where('doc_id',Auth::user()->fid)->pluck('doc_id')->toArray();

    $query = StudentAssignment::query();

        // select lessons of courses of student or doctor
        $query->whereIn('doc_id', $stdAnss);

        if ($request->search)
            $query->where('name', 'like', '%'. $request->search . '%');

        if ($request->assign_id > 0)
            $query->where('assign_id', 'like', '%'. $request->assign_id . '%');

        if ($request->sbj_id > 0)
            $query->where('sbj_id', 'like', '%'. $request->sbj_id . '%');

        if ($request->lesson_id > 0)
            $query->where('lesson_id', 'like', '%'. $request->lesson_id . '%');

        if ($request->doc_id > 0)
            $query->where('doc_id', 'like', '%'. $request->doc_id . '%');

        $stdAssignments = $query->latest()->get();

        if (Auth::user()->type == 'admin' || Auth::user()->type == 'super_admin'){
            $stdAssignments = StudentAssignment::all();
        }

        return view('dashboard.student_assignments.index', compact('assignments','stdAssignments', 'students', 'subjects', 'lessons', 'doctors'));
    }

    //function to get report
    public function getReport(Request $request){

        $subjects = Subject::all();
        $anssData = StudentAssignment::select('student_id', 'assign_id', 'sbj_id', 'doc_id','created_at', 'grade')
                                    ->where('sbj_id', $request->sbj_id)->latest()->get();

        return view('dashboard.student_assignments.report', compact('anssData', 'subjects'));

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

    //function to get assignmts by lesson fillter
    public function get_by_lesson(Request $request)
    {
        //abort_unless(\Gate::allows('city_access'), 401);

        if (!$request->lesson_id) {
            $html = '<option value="">'.trans('site.assignments').'</option>';
        } else {
            $html = '';
            $assignments = Assignment::where('lesson_id', $request->lesson_id)->get();
            foreach ($assignments as $assignment) {
                $html .= '<option value="'.$assignment->id.'">'.$assignment->name.'</option>';
            }
        }

        return response()->json(['html' => $html]);
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

    public function addGrade(Request $request,$id){
        $stdAnss = StudentAssignment::find($request->hidden_id);

        $stdAnss->grade = $request->grade;
        $stdAnss->save();
        /*$stdAnss->update([
            "grade" => $request->grade
        ]);*/

       /* if($error->fails()){
            return response()->json(['errors' => $error->errors()->all()]);
        }*/
        //return $stdAnss;

        return response()->json(['success'=>'Data Updated Succefully']);

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
