<?php

namespace App\Http\Controllers\Dashboard;

use App\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Exports\SubjectsExport;
use App\Imports\SubjectsImport;
use App\Level;
use App\StudentSubject;
use App\Subject;
use App\DoctorCourse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Auth;


class SubjectController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_subjects'])->only('index');
        $this->middleware(['permission:create_subjects'])->only('create');
        $this->middleware(['permission:update_subjects'])->only('edit');
        $this->middleware(['permission:delete_subjects'])->only('destroy');

    }
    public function importExportView()
    {
       return view('dashboard.subjects.index');
    }

    public function export()
    {
        return Excel::download(new SubjectsExport, 'subjects.xlsx');
    }

    public function import()
    {
        Excel::import(new SubjectsImport,request()->file('file'));

        return back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$test = DB::select("SELECT * FROM doctors");
        dd($test);*/
        //dd(auth()->user()->type);
        if(auth()->user()->type == 'admin' || auth()->user()->type == 'super_admin'){
            $doctors = DB::select("SELECT * FROM doctors");
            //dd($doctors);
            $subjects = Subject::when($request->search, function ($q) use ($request){
                return $q->where('name', 'like', '%'. $request->search . '%')
                    ->orWhere('code', 'like', '%'. $request->search . '%')
                    ->orWhere('id', 'like', '%'. $request->course_id . '%');

            })->when($request->doctor_id, function ($q) use ($request){
            return $q->join('doctor_courses', 'courses.id', '=' , 'doctor_courses.course_id')
                ->where('doctor_courses.doctor_id', 'like', '%'. $request->doctor_id . '%');

            })->get();
            return view('dashboard.subjects.index', compact('subjects','doctors'));
        }
        elseif(auth()->user()->type == 'doctor' || auth()->user()->type == 'student'){
            $stdSbsIds = []; // id of courses of student of doctors

            if (Auth::user()->type == 'doctor')
                $stdSbsIds =  DoctorCourse::where('doctor_id', Auth::user()->fid)->pluck('course_id')->toArray();

            else if (Auth::user()->type == 'student')
                $stdSbsIds =  StudentSubject::where('student_id', Auth::user()->fid)->pluck('course_id')->toArray();

            $doctors = DB::select("SELECT * FROM doctors");
            //dd($doctor_id);

            $subjects = Subject::when($request->search, function ($q) use ($request){
                return $q->where('name', 'like', '%'. $request->search . '%')
                    ->orWhere('code', 'like', '%'. $request->search . '%');

            })
            ->whereIn('id', $stdSbsIds)
            ->get();
            return view('dashboard.subjects.index', compact('subjects','doctors'));

        }else{
            return redirect()->back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::all();
        $doctors = Doctor::all();
        return view('dashboard.subjects.create', compact('doctors', 'levels'));
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
            'name' => 'required|unique:courses',
            'code' => 'required|unique:courses',
            'notes' => 'nullable',
            'hours' => 'required',
            'level_id' => 'required',
        ]);

        $request_data = $request->all();

        Subject::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.subjects.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $levels = Level::all();
        $doctors = Doctor::all();
        return view('dashboard.subjects.edit', compact('subject','doctors','levels'));
    }

    public function editdoc(Subject $subject)
    {
        $doctors = Doctor::all();
        return view('dashboard.subjects.editdoc', compact('subject','doctors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        if($request['doc_id']){
            $request->validate([
                'doc_id' => 'required',
            ]);

            $request_data = $request->all();

            $subject->update($request_data);

            session()->flash('success', __('site.assigned_successfully'));
            return redirect()->route('dashboard.subjects.index');

        }else{
            $request->validate([
                'name' => ['required', Rule::unique('courses')->ignore($subject->id)],
                'code' => ['required', Rule::unique('courses')->ignore($subject->id)],
                'notes' => 'nullable',
                'hours' => 'required',
                'level_id' => 'required',
                //'sbj_doc' => 'required',
            ]);

            $request_data = $request->all();

            $subject->update($request_data);

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.subjects.index');

        }

    }

    public function updatedoc(Request $request, Subject $subject,$sbj_id)
    {
        if($subject->id == $sbj_id){
            $request->validate([
                'doc_id' => 'required',
            ]);

            $request_data = $request->all();

            $subject->update($request_data);

            session()->flash('success', __('site.assigned_successfully'));
            return redirect()->route('dashboard.subjects.index');
        }

    }


    /**
     * assign doctor view.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign(Subject $course)
    {
        return view('dashboard.subjects.doctor-register', compact('course'));
    }


    /**
     * assign doctor view.
     *
     * @return \Illuminate\Http\Response
     */
    public function performAssign(Subject $course, Request $request)
    {
        // remove old
        $course->docSubjs()->delete();

        // add new
        $counter = 0;
        foreach($request->doctor_id as $doctor) {
            if ($request->assign[$counter] == 1) {
                DoctorCourse::create([
                    "course_id" => $course->id,
                    "doctor_id" => $doctor
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
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if ($subject->lessons()->exists() || $subject->stdSbjs()->exists())
            {
                notify()->error(trans('site.can_not_delete_related_items'),"Error","topRight");
                return redirect()->route('dashboard.subjects.index');

            }else{
                $subject->delete();
                session()->flash('success', __('site.deleted_successfully'));
                return redirect()->route('dashboard.subjects.index');
            }
    }
}
