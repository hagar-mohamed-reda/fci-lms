<?php

namespace App\Http\Controllers\Dashboard;

use App\Assignment;
use App\Doctor;
use App\DoctorCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\StudentSubject;
use App\Subject;
use Auth;

class AssignmentController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_assignments'])->only('index');
        $this->middleware(['permission:create_assignments'])->only('create');
        $this->middleware(['permission:update_assignments'])->only('edit');
        $this->middleware(['permission:delete_assignments'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stdSbsIds = []; // id of courses of student of doctors

        if (Auth::user()->type == 'doctor')
            $stdSbsIds =  DoctorCourse::where('doctor_id', Auth::user()->fid)->pluck('course_id')->toArray();

        else if (Auth::user()->type == 'student')
            $stdSbsIds =  StudentSubject::where('student_id', Auth::user()->fid)->pluck('course_id')->toArray();


        $subjects = Subject::where(function($q) use($stdSbsIds) {
            if (Auth::user()->type != 'admin')
                $q->whereIn('id', $stdSbsIds);
        })->get();

        $lessons = Lesson::where(function($q) use($stdSbsIds) {
            if (Auth::user()->type != 'admin')
                $q->whereIn('sbj_id', $stdSbsIds);
        })->get();



        $doctors = Doctor::all();
        $query = Assignment::query();

        // select lessons of courses of student or doctor
        $query->whereIn('sbj_id', $stdSbsIds);

        if ($request->search)
            $query->where('name', 'like', '%'. $request->search . '%');

        if ($request->sbj_id > 0)
            $query->where('sbj_id', 'like', '%'. $request->sbj_id . '%');

        if ($request->lesson_id > 0)
            $query->where('lesson_id', 'like', '%'. $request->lesson_id . '%');

        if ($request->doc_id > 0)
            $query->where('doc_id', 'like', '%'. $request->doc_id . '%');

        $assignments = $query->latest()->get();


        if (Auth::user()->type == 'admin' || Auth::user()->type == 'super_admin'){
            $assignments = Assignment::all();
            $subjects = Subject::all();
            $lessons = Lesson::all();
        }

        return view('dashboard.assignments.index', compact('assignments','lessons', 'subjects', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessons = Lesson::all();
        return view('dashboard.assignments.create', compact('lessons'));
    }

    //function to get lessons by subject fillter
    public function get_by_subject(Request $request)
    {
        //abort_unless(\Gate::allows('city_access'), 401);

        if (!$request->sbj_id) {
            $html = '<option value="">'.trans('site.lessons').'</option>';
        } else {
            $html = '';
            $lessons = Lesson::where('sbj_id', $request->sbj_id)->get();
            foreach ($lessons as $lesson) {
                $html .= '<option value="'.$lesson->id.'">'.$lesson->name.'</option>';
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
            'name'             => 'required',
            'start_date'       => 'required',
            'end_date'         => 'required',
            'lesson_id'        => 'required',
            'doc_id'        => 'required',
            'sbj_id'        => 'required',
            'pdf_quest'        => 'required',

        ]);
        $request_data = $request->except('pdf_quest');

        if($request->hasFile('pdf_quest')){
            $pdf_quest = $request->file('pdf_quest');
            $filename=time().'.'.$pdf_quest->getClientOriginalExtension();
            $destinationPath = public_path('uploads/questions');

            $request_data['pdf_quest'] = $filename;

            $pdf_quest->move($destinationPath,$filename);
            //dd($pdf_quest);
        }

        Assignment::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.assignments.index');

    }

    public function show_pdf($id)
    {
        $data = Assignment::find($id);
        return view('dashboard.assignments.pdf_details', compact('data'));
    }
    //function to download pdf file
    public function download_pdf($pdf_quest){
        return response()->download('uploads/questions/'.$pdf_quest);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        $lessons = Lesson::all();
        return view('dashboard.assignments.edit', compact('assignment', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'name'             => 'required',
            'start_date'       => 'required',
            'end_date'         => 'required',
            'lesson_id'        => 'required',
            'pdf_quest'        => 'required',

        ]);
        $request_data = $request->except('pdf_quest');

        if($request->hasFile('pdf_quest')){
            $pdf_quest = $request->file('pdf_quest');
            $filename=time().'.'.$pdf_quest->getClientOriginalExtension();
            $destinationPath = public_path('uploads/questions');

            $request_data['pdf_quest'] = $filename;

            $pdf_quest->move($destinationPath,$filename);
            //dd($pdf_quest);
        }


        $assignment->update($request_data);


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.assignments.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        if ($assignment->stdAssign()->exists())
            {

                notify()->error(trans('site.can_not_delete_related_items'),"Error","topRight");
                return redirect()->route('dashboard.assignments.index');

            }else{
                $assignment->delete();
                session()->flash('success', __('site.deleted_successfully'));
                return redirect()->route('dashboard.assignments.index');
            }
    }
}
