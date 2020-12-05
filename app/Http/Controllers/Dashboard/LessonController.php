<?php

namespace App\Http\Controllers\Dashboard;

use App\Doctor;
use App\DoctorCourse;
use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentSubject;
use App\Subject;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Auth;
class LessonController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_lessons'])->only('index');
        $this->middleware(['permission:create_lessons'])->only('create');
        $this->middleware(['permission:update_lessons'])->only('edit');
        $this->middleware(['permission:delete_lessons'])->only('destroy');

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

        $doctors = Doctor::all();

        $query = Lesson::query();

        // select lessons of courses of student or doctor
        $query->whereIn('sbj_id', $stdSbsIds);

        if ($request->search)
            $query->where('name', 'like', '%'. $request->search . '%');

        if ($request->sbj_id > 0)
            $query->where('sbj_id', 'like', '%'. $request->sbj_id . '%');

        if ($request->doc_id > 0)
            $query->where('doc_id', 'like', '%'. $request->doc_id . '%');

        $lessons = $query->latest()->get();

        if (Auth::user()->type == 'admin' || Auth::user()->type == 'super_admin')
            $lessons = Lesson::all();
            //$query->all();



        return view('dashboard.lessons.index', compact('lessons', 'subjects', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('dashboard.lessons.create', compact('subjects'));
    }

    public function get_by_doctor(Request $request)
    {
        //abort_unless(\Gate::allows('city_access'), 401);

        if (!$request->doc_id) {
            $html = '<option value="">'.trans('site.subjects').'</option>';
        } else {
            $html = '';
            // $subjects = Subject::where('doc_id', $request->doc_id)->get();
            $docCourses = DoctorCourse::where('doctor_id', $request->doc_id)->get();
            foreach ($docCourses as $docCourse) {
                $html .= '<option value="'.$docCourse->subjects['id'].'">'.$docCourse->subjects['name'].'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function fileCreate()
    {
        return view('dashboard.lessons.create');
    }

    public function fileStore(Request $request)
    {
        /*$request->validate([
            'name'          => 'required',
            'date'          => 'required',
            'youtube_link'  => 'required',
            'sbj_id'        => 'required',
            'pdf_file'        => 'required',
            'pptx_file' => 'required',
        ]);

        $request_data = $request->except(['pdf_file', 'pptx_file']);

        if($request->hasFile('pdf_file') or $request->hasFile('pptx_file')){

            $pdf_file = $request->file('pdf_file');
            $pdf_filename=time().'.'.$pdf_file->getClientOriginalExtension();
            $destinationPath = public_path('uploads');
            $pdf_file->move($destinationPath,$pdf_filename);
            $request_data['pdf_file'] = $request->pdf_file;

            $pptx_file = $request->file('pptx_file');
            $pptx_filename=time().'.'.$pptx_file->getClientOriginalExtension();
            $destinationPath = public_path('uploads');
            $pptx_file->move($destinationPath,$pptx_filename);
            $request_data['pptx_file'] = $request->pptx_file;

            //$request_data = $request->all();
            //$data->save();
        }

        Lesson::create($request_data);
        //$data->update(['pdf_file','powerpoint_file']);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.lessons.index');*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lesson $lesson)
    {
        /*if($request->file('pdf_file')){
            $pdf_file = $request->file('pdf_file');
            $pdf_filename=time().'.'.$pdf_file->getClientOriginalExtension();
            $destinationPath = base_path('storage');
            $pdf_file->move($destinationPath,$pdf_filename);
            $data->pdf_file = $pdf_filename;
        }*/
        //$request->doc_id = $request->get('doc_id');

        $request->validate([
            'name'          => 'required',
            'date'          => 'required',
            'youtube_link'  => 'nullable',
            'sbj_id'        => 'required',
            'doc_id'        => 'required',
            'pdf_file'      => 'nullable',
            'pptx_file'     => 'required',
            'mp4_file'     => 'nullable',
        ]);

        $request_data = $request->except(['pdf_file', 'pptx_file']);

        if($request->hasFile('pptx_file')){

            if($request->hasFile('pdf_file')){
            $pdf_file = $request->file('pdf_file');
            $pdf_filename=time().'.'.$pdf_file->getClientOriginalExtension();

            $request_data['pdf_file'] = $pdf_filename;

            $destinationPath = public_path('uploads/lessons');
            $pdf_file->move($destinationPath,$pdf_filename);
            }
            if($request->hasFile('mp4_file')){
                $mp4_file = $request->file('mp4_file');
                $mp4_filename=time().'.'.$mp4_file->getClientOriginalExtension();

                $request_data['mp4_file'] = $mp4_filename;

                $destinationPath = public_path('uploads/lessons');
                $mp4_file->move($destinationPath,$mp4_filename);
                }
            /*if($pdf_file->move($destinationPath,$pdf_filename)){
                $less = new Lesson();
                $less->pdf_file = $pdf_filename;
                $less->save();
            };*/
            //dd($pdf_file);

            $pptx_file = $request->file('pptx_file');
            $pptx_filename=time().'.'.$pptx_file->getClientOriginalExtension();
            $request_data['pptx_file'] = $pptx_filename;

            $destinationPath = public_path('uploads/lessons');
            $pptx_file->move($destinationPath,$pptx_filename);

            /*if($pptx_file->move($destinationPath,$pptx_filename)){
                $less = new Lesson();
                $less->pptx_file = $pptx_filename;
                $less->save();
            };*/

            //$data->powerpoint_file = $pptx_file;

            //$request_data = $request->all();
            //$data->save();
        }

        Lesson::create($request_data);
        //$data->update(['pdf_file','powerpoint_file']);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.lessons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    //function to show pdf file
    public function show_pdf($id)
    {
        $data = Lesson::find($id);
        return view('dashboard.lessons.pdf_details', compact('data'));
    }
    //function to download pdf file
    public function download_pdf($pdf_file){
        return response()->download('uploads/lessons/'.$pdf_file);
    }

    //function to download pptx file
    public function download_pptx($pptx_file){
        return response()->download('uploads/lessons/'.$pptx_file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $subjects = Subject::all();
        return view('dashboard.lessons.edit',compact('lesson', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'name'          => 'required',
            'date'          => 'required',
            'youtube_link'  => 'nullable',
            'sbj_id'        => 'required',
            'pdf_file'      => 'nullable',
            'pptx_file'     => 'required',
            'mp4_file'     => 'nullable',
        ]);

        $request_data = $request->except(['pdf_file', 'pptx_file']);

        if($request->hasFile('pptx_file')){

            if($request->hasFile('pdf_file')){
                $pdf_file = $request->file('pdf_file');
                $pdf_filename=time().'.'.$pdf_file->getClientOriginalExtension();
                $request_data['pdf_file'] = $pdf_filename;
                $destinationPath = public_path('uploads/lessons');
                $pdf_file->move($destinationPath,$pdf_filename);
            }

            if($request->hasFile('mp4_file')){
                $mp4_file = $request->file('mp4_file');
                $mp4_filename=time().'.'.$mp4_file->getClientOriginalExtension();
                $request_data['mp4_file'] = $mp4_filename;
                $destinationPath = public_path('uploads/lessons');
                $mp4_file->move($destinationPath,$mp4_filename);
            }

            $pptx_file = $request->file('pptx_file');
            $pptx_filename=time().'.'.$pptx_file->getClientOriginalExtension();
            $request_data['pptx_file'] = $pptx_filename;

            $destinationPath = public_path('uploads/lessons');
            $pptx_file->move($destinationPath,$pptx_filename);

            //$request_data = $request->all();
            //$data->save();
        }

        $lesson->update($request_data);
        //Lesson::create($request_data);
        //$data->update(['pdf_file','powerpoint_file']);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.lessons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        if ($lesson->assignments()->exists())
            {
                notify()->error(trans('site.can_not_delete_related_items'),"Error","topRight");
                return redirect()->route('dashboard.lessons.index');

            }else{
                $lesson->delete();
                session()->flash('success', __('site.deleted_successfully'));
                return redirect()->route('dashboard.lessons.index');
            }
    }
}
