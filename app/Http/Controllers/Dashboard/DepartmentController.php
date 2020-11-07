<?php

namespace App\Http\Controllers\Dashboard;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Level;

class DepartmentController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_departments'])->only('index');
        $this->middleware(['permission:create_departments'])->only('create');
        $this->middleware(['permission:update_departments'])->only('edit');
        $this->middleware(['permission:delete_departments'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::when($request->search, function ($q) use ($request){
            return $q->where('name', 'like', '%'. $request->search . '%');
        })->latest()->paginate(6);

        return view('dashboard.departments.index', compact('departments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::all();
        return view('dashboard.departments.create',compact('levels'));
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
            'name' => 'required',
            'level_id' => 'required',
            'notes' => 'nullable',

        ]);

        $request_data = $request->all();
        Department::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $levels = Level::all();
        return view('dashboard.departments.edit', compact('department', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
            'level_id' => 'required',
            'notes' => 'nullable',

        ]);

        $request_data = $request->all();
        $department->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.departments.index');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.departments.index');
    }
}
