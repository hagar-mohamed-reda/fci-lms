<?php

namespace App\Http\Controllers\Dashboard;

use App\Problem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\helper\Message;
use DataTables;
use App\User;

class ComplainController extends Controller
{
    public function student()
    {
        $stdProblems = Problem::where('type', 'student');

        return view("dashboard.student_problem.index",compact('stdProblems'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctor()
    {
        $docProblems = Problem::where('type', 'doctor');
        return view("dashboard.doctor_problem.index",compact('docProblems'));
    }
    /**
     * return json data
     */
    public function getDataStudent() {
        $query = Problem::query()->where('type', 'student');

        if (request()->status)
            $query->where('status', request()->status);
        else
            $query->where('status', 'default');

        if (request()->department_id) {
            $codes = User::where('department_id', request()->department_id)->pluck('code')->toArray();
            $codesList = [];
            foreach($codes as $code)
                $codesList[] = str_replace(" ", "", $code);

            $query->whereIn('code', $codesList);
        }

        if (request()->level_id) {
            $codes = User::where('level_id', request()->level_id)->pluck('code')->toArray();
            $codesList = [];
            foreach($codes as $code)
                $codesList[] = str_replace(" ", "", $code);

            $query->whereIn('code', $codesList);
        }

        return DataTables::eloquent($query)
                        ->addColumn('action', function(Problem $problem) {
                            return view("dashboard.student_problem.action", compact("problem"));
                        })
                         ->editColumn('user_id', function(Problem $problem) {
                            return optional($problem->user)->name;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }
    /**
     * return json data
     */
    public function getDataDoctor() {
        $query = Problem::query()->where('type', 'doctor');

        if (request()->status)
            $query->where('status', request()->status);
        else
            $query->where('status', 'default');

        return DataTables::eloquent($query)
                        ->addColumn('action', function(Problem $problem) {
                            return view("dashboard.doctor_problem.action", compact("problem"));
                        })
                         ->editColumn('user_id', function(Problem $problem) {
                            return optional($problem->user)->name;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }


    public function store(Request $request) {

        $redirect = $request->type == 'student'? 'students/login' : 'dashboard/login';
        $validator = validator()->make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
            'type' => 'required',
            'notes' => 'required',
        ], [
            "phone.required" => __("phone_required"),
            "name.required" => __("name_required"),
            "type.required" => __("type_required"),
            "notes.required" => __("your must write your complaint"),
        ]);

        //$redirect = $request->type == 'student'? 'students/login' : 'dashboard/login';

        if ($validator->fails()) {
            $key = $validator->errors()->first();
            //return redirect($redirect . "?status=0&msg=" . $key);
            notify()->error($key,"error","topRight");

            return redirect()->back();
        }

        $problem = Problem::create($request->all());

        notify()->success(trans('site.your_problem_sent_to_admin'),"Success","topRight");
        //return redirect($redirect . "?status=1&msg=" . __('your complaint sent to admin'));
        return redirect()->back();
    }


    public function update(Problem $problem, Request $request) {

        try {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;

            $problem->update($data);

            notify(__('update complaint'), __('update complaint for ') . " " . $problem->name, "fa fa-frown-o");
            //return Message::success(Message::$EDIT);
            return redirect()->back();
        } catch (\Exception $ex) {
            //return Message::error(Message::$ERROR);
            return redirect()->back();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        $docProblems = Problem::where('type', 'doctor');
        return view("dashboard.doctor_problem.index",compact('docProblems'));
        */

        $stdProblems = Problem::where('type', 'student');
        return view("dashboard.student_problem.index",compact('stdProblems'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function show(Problem $problem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function edit(Problem $problem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Problem $problem)
    {
        //
    }
}
