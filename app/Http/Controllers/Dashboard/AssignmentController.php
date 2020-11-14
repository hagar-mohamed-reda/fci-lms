<?php

namespace App\Http\Controllers\Dashboard;

use App\Assignment;
use App\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\StudentSubject;
use App\Subject;

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
        $stdSbs = StudentSubject::all();
        $subjects = Subject::all();
        $doctors =Doctor::all();

        $lessons = Lesson::all();
        $assignments = Assignment::when($request->search, function ($q) use ($request){
            return $q->where('name', 'like', '%'. $request->search . '%');

        })->when($request->lesson_id, function ($q) use ($request){
          return $q->where('lesson_id', 'like', '%'. $request->lesson_id . '%');

        })->when($request->sbj_id, function ($q) use ($request){
            return $q->where('sbj_id', 'like', '%'. $request->sbj_id . '%');

          })->when($request->doc_id, function ($q) use ($request){
            return $q->where('doc_id', 'like', '%'. $request->doc_id . '%');

            })->latest()->get();

        return view('dashboard.assignments.index', compact('assignments','lessons','stdSbs','subjects', 'doctors'));
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
        $assignment->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.assignments.index');
    }
}
