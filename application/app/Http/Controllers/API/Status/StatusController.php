<?php

namespace App\Http\Controllers\Api\Status;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    //

    public function update_job_status(Request $request, $id){
            $data = Project::find($id);
            $data->project_status = $request->project_status;
            $data->save();
            return response()->json($data);
    }

    public function update_task_status(Request $request, $id){
        //  return $request;
        $cdata = Task::find($id);
        $cdata->task_status = $request->task_status;
        $cdata->save();
        return response()->json($cdata);
}
}
