<?php

namespace App\Http\Controllers\Dashboard;

use App\Doctor;
use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentSubject;
use App\Subject;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Storage;
use Imagick;
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
        $stdSbs = StudentSubject::all();
        $subjects = Subject::all();
        $doctors = Doctor::all();
        $lessons = Lesson::when($request->search, function ($q) use ($request){
            return $q->where('name', 'like', '%'. $request->search . '%');

        })->when($request->sbj_id, function ($q) use ($request){
          return $q->where('sbj_id', 'like', '%'. $request->sbj_id . '%');

        })->when($request->doc_id, function ($q) use ($request){
        })->latest()->get();

        return view('dashboard.lessons.index', compact('lessons','subjects', 'stdSbs', 'doctors'));
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
        ]);

        $request_data = $request->except(['pdf_file', 'pptx_file']);

        if($request->hasFile('pptx_file')){

            $pdf_file = $request->file('pdf_file');
            $pdf_filename=time().'.'.$pdf_file->getClientOriginalExtension();

            $request_data['pdf_file'] = $pdf_filename;

            $destinationPath = public_path('uploads/lessons');
            $pdf_file->move($destinationPath,$pdf_filename);

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
        $lesson->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.lessons.index');
    }
}
