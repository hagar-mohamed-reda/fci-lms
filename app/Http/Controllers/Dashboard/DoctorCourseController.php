<?php

namespace App\Http\Controllers\Dashboard;

use App\Doctor;
use App\DoctorCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;

class DoctorCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        $doctors = Doctor::all();
        $docSubjects = DoctorCourse::all();
        return view('dashboard.doctor_courses.create', compact('subjects', 'doctors','docSubjects'));
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
            'doctor_id' => 'required',
        ]);


        if(DoctorCourse::where('doctor_id','=', $request->doctor_id)
                    ->where('course_id', '=', $request->course_id)
                    ->exists()
        ){
            notify()->error(trans('site.this_doctor_already_exists'),"Error","topRight");
            return redirect()->back();
            //return redirect()->route('dashboard.students.index');
        }else{
            $request_data = $request->all();

            DoctorCourse::create($request_data);

            session()->flash('success', __('site.added_successfully'));
            //return redirect()->route('dashboard.subjects.index');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DoctorCourse  $doctorCourse
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorCourse $doctorCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DoctorCourse  $doctorCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorCourse $doctorCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DoctorCourse  $doctorCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorCourse $doctorCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DoctorCourse  $doctorCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorCourse $doctorCourse)
    {
        $doctorCourse->delete();
        session()->flash('success', __('site.deleted_successfully'));
        //return redirect()->route('dashboard.student_subjects.index');
        return redirect()->back();
    }
}
