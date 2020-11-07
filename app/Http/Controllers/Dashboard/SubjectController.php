<?php

namespace App\Http\Controllers\Dashboard;

use App\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Exports\SubjectsExport;
use App\Imports\SubjectsImport;
use App\StudentSubject;
use App\Subject;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


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
                    ->orWhere('code', 'like', '%'. $request->search . '%');

            })->when($request->doc_id, function ($q) use ($request){
            return $q->where('doc_id', 'like', '%'. $request->doc_id . '%');

            })->get();
            return view('dashboard.subjects.index', compact('subjects','doctors'));
        }
        elseif(auth()->user()->type == 'doctor' || auth()->user()->type == 'student'){

            $stdSbs = StudentSubject::all();
            $doctors = DB::select("SELECT * FROM doctors");
            //dd($doctor_id);

            $subjects = Subject::when($request->search, function ($q) use ($request){
                return $q->where('name', 'like', '%'. $request->search . '%')
                    ->orWhere('code', 'like', '%'. $request->search . '%');

            })->get();
            //$subjects = Subject::where('doc_id' ,'=',  $doctor_id );
            //$subjects = $query->where('doc_id' ,'=',  $doctor_id);
                        //dd($subjects);
            return view('dashboard.subjects.index', compact('subjects','doctors','stdSbs'));

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
        $doctors = Doctor::all();
        return view('dashboard.subjects.create', compact('doctors'));
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
            'name' => 'required|unique:subjects',
            'code' => 'required|unique:subjects',
            'description' => 'nullable',
            'notes' => 'nullable',
            'hours' => 'required',
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
        $doctors = Doctor::all();
        return view('dashboard.subjects.edit', compact('subject','doctors'));
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
                'name' => ['required', Rule::unique('subjects')->ignore($subject->id)],
                'code' => ['required', Rule::unique('subjects')->ignore($subject->id)],
                'description' => 'nullable',
                'notes' => 'nullable',
                'hours' => 'required',
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.subjects.index');
    }
}
