<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Job;
use App\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $jobs = Job::all();
        
        return view('admin.job.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('admin.job.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'job_name' => 'required',
            'job_type' => 'required',
            'job_discription' => 'required',
            'job_location' => 'required',
            'requirement' => 'required',
            'salary' => 'required',
        ]);

        Job::create(request(['user_id','job_name','job_type','job_discription','job_location','requirement','salary']));

        return redirect('/admin/job');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::find($id);
        $users = User::pluck('name', 'id');
        
        return view('admin.job.edit', compact('job','id','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $job = Job::find($id);
        $job->job_name = $request->get('job_name');
        $job->job_type = $request->get('job_type');
        $job->salary = $request->get('salary');
        $job->job_discription = $request->get('job_discription');
        $job->job_location = $request->get('job_location');
        $job->requirement = $request->get('requirement');    
        $job->save();
        return redirect('/admin/job');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);
        $job->delete();

        return redirect('/admin/job');
    }
}
