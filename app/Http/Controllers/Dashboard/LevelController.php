<?php

namespace App\Http\Controllers\Dashboard;

use App\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read_levels'])->only('index');
        $this->middleware(['permission:create_levels'])->only('create');
        $this->middleware(['permission:update_levels'])->only('edit');
        $this->middleware(['permission:delete_levels'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $levels = Level::when($request->search, function ($q) use ($request){
            return $q->where('name', 'like', '%'. $request->search . '%');
        })->latest()->get();

        return view('dashboard.levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.levels.create');
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

        ]);

        $request_data = $request->all();
        Level::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.levels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        return view('dashboard.levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $request_data = $request->all();
        $level->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        if ($level->students()->exists() || $level->departments()->exists()
            )
            {
                notify()->error("Can not delete this item it has related relations","Error","topRight");
                return redirect()->route('dashboard.levels.index');

            }else{
                $level->delete();
                session()->flash('success', __('site.deleted_successfully'));
                return redirect()->route('dashboard.levels.index');
            }
    }
}
