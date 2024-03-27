<?php

use App\Http\Controllers\API\User\AuthenticateController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Home\HomeController;
use App\Http\Controllers\API\Home\TestController;
use App\Http\Controllers\API\Projects\ProjectController;
use App\Http\Controllers\API\Event\EventController;
use App\Http\Controllers\API\Contacts\ContactController;
use App\Http\Controllers\API\Leave\LeaveController;
use App\Http\Controllers\API\Status\StatusController;

use App\Http\Controllers\API\Comments\CommentsController;
use App\Http\Controllers\API\Notes\Notes;

use App\Http\Controllers\API\Task\TaskController;
use App\Http\Controllers\API\ProblemReport\ProblemReportApiController;
use App\Http\Controllers\API\Files\Files;
use App\Http\Controllers\API\Files\Fileupload;
use App\Http\Controllers\API\FileGroups\FileGroups;


use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get("/login", function(){
//     dd("jhg");
// })->name('login');
// Route::post("/login", "Authenticate@logInAction");

Route::post('login', [AuthenticateController::class, 'loginUser'])->name('login');

Route::post('test', [AuthenticateController::class, 'LoginAction'])->name('test');
Route::get('check', [HomeController::class, 'index'])->name('check');

Route::middleware('auth:sanctum')->get('dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::middleware('auth:sanctum')->get('team/{id?}', [ProjectController::class, 'team'])->name('job-team');
// Route::middleware('auth:sanctum')->get('all/projects/dropdown', [ProjectController::class, 'indexProjectDropdown']);
Route::middleware('auth:sanctum')->post('all/projects/dropdown', [ProjectController::class, 'indexProjectDropdown']);

// Route::middleware('auth:sanctum')->get('paginated/projects/{id?}', [ProjectController::class, 'indexProjectPaginated'])->name('projects');

Route::middleware('auth:sanctum')->post('paginated/projects/{id?}', [ProjectController::class, 'indexProjectPaginated'])->name('projects');

Route::middleware('auth:sanctum')->get('job-activity/{id?}', [ProjectController::class, 'activity_log'])->name('job-activity');

Route::middleware('auth:sanctum')->get('job-status-detail/{id}', [ProjectController::class, 'showDynamic'])->name('job-status-detail');

Route::middleware('auth:sanctum')->post("/fileupload", "API\Files\Fileupload@save");

 //dynamic load
 Route::any("/{project}/{section}", [ProjectController::class, 'showDynamic'] )
        ->where(['project' => '[0-9]+', 'section' => 'details|comments|files|tasks|invoices|payments|timesheets|expenses|estimates|milestones|tickets|notes|logs|teams|locations']);

Route::middleware('auth:sanctum')->post('job/{project}/change-status',[ProjectController::class,'changeStatusUpdate'])->name('changeJobStatusUpdate');

Route::middleware('auth:sanctum')->get('show-my-calender', [TaskController::class, 'showMyCalander'])->name('show-my-calender');
 
// Route::middleware('auth:sanctum')->get('task/{id?}', [TaskController::class, 'indexUnAllocated'])->name('c');
// Route::middleware('auth:sanctum')->post('/task-store', [TaskController::class, 'store'])->name('task-store');

Route::middleware('auth:sanctum')->get('notification', [EventController::class, 'topNavEvents'])->name('notification');

Route::middleware('auth:sanctum')->get('user-edit/{id}', [ContactController::class, 'edit'])->name('user-edit');

Route::middleware('auth:sanctum')->get('leave', [LeaveController::class, 'index'])->name('leave');
Route::middleware('auth:sanctum')->post('leave', [LeaveController::class, 'store'])->name('leave_store');

Route::middleware('auth:sanctum')->post('user-update/{id}', [ContactController::class, 'update'])->name('user-update');

Route::middleware('auth:sanctum')->post('update-password', [UserController::class, 'updatePasswordAction'])->name('update-password');

Route::middleware('auth:sanctum')->post('update-job/{id}', [StatusController::class, 'update_job_status'])->name('update-job');

// Route::middleware('auth:sanctum')->post('update-task/{id}', [StatusController::class, 'update_task_status'])->name('update-task');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware('auth:sanctum')->post("task/{task}/update-status", [TaskController::class,"updateStatus"]);

// Route::middleware('auth:sanctum')->get('problemreports', [ProblemReportApiController::class, 'index'])->name('index');

//TICKETS
Route::group(['middleware' => ["auth:sanctum",  ],'prefix' => 'problemreports'], function () {
    Route::any("/", "API\ProblemReport\ProblemReportApiController@index");
    Route::post("/store", "API\ProblemReport\ProblemReportApiController@store");
    Route::post("/update", "API\ProblemReport\ProblemReportApiController@update");
    Route::get("/show/{ticket}", "API\ProblemReport\ProblemReportApiController@show");
    Route::get("/{x}/editdetails", "API\ProblemReport\ProblemReportApiController@editDetails")->where('x', '[0-9]+');
    Route::get("/{ticket}/reply", "API\ProblemReport\ProblemReportApiController@reply")->where('x', '[0-9]+');
    Route::post("/{ticket}/postreply", "API\ProblemReport\ProblemReportApiController@storeReply")->where('x', '[0-9]+');
    Route::post("/delete", "API\ProblemReport\ProblemReportApiController@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "API\ProblemReport\ProblemReportApiController@changeCategory");
    Route::post("/change-category", "API\ProblemReport\ProblemReportApiController@changeCategoryUpdate");
    Route::get("/attachments/download/{uniqueid}", "API\ProblemReport\ProblemReportApiController@downloadAttachment");
});
//Files
Route::group(['middleware' => ["auth:sanctum",  ],'prefix' => 'files'], function () {
    Route::any("/", "API\Files\Files@index");
    Route::any("/upload", "API\Files\Files@store");
    Route::any("/search", "API\Files\Files@index");
    Route::get("/getimage", "API\Files\Files@showImage");
    Route::get("/download", "API\Files\Files@download");
    Route::post("/delete", "API\Files\Files@destroy")->middleware(['demoModeCheck']);
    Route::post("/{file}/rename", "API\Files\Files@renameFile")->middleware(['demoModeCheck']);
        Route::post("/{file}/move", "API\Files\Files@moveFile")->middleware(['demoModeCheck']);
});

//FILE GROUPS
Route::group(['middleware' => ["auth:sanctum",  ],'prefix' => 'filegroups'], function () {
    Route::any("/search", "API\FileGroups\FileGroupsController@index");
    Route::post("/savefolder", "API\FileGroups\FileGroupsController@store");
        // Route::post("/savefolder", FileGroup::class,'store');
    Route::post("/showlist", "API\FileGroups\FileGroupsController@showlist");
    Route::post("/updatefolders", "API\FileGroups\FileGroupsController@update");
    Route::post("/deletefolder", "API\FileGroups\FileGroupsController@delete");
    Route::post("/{group}/rename", "API\FileGroups\FileGroupsController@renameFile")->middleware(['demoModeCheck']);
});
//COMMENTS
Route::group(['middleware' => ["auth:sanctum",  ],'prefix' => 'comments'], function () {
    Route::post("/comment/store", "API\Comments\CommentsController@store");
    Route::any("/search", "API\Comments\CommentsController@index");

    Route::any("/single/comment/{id}", "API\Comments\CommentsController@singleComment");
    Route::delete("/delete/{comment_id}","API\Comments\CommentsController@destroy");
});



//NOTES
Route::group(['middleware' => ["auth:sanctum",  ],'prefix' => 'notes'], function () {
      Route::post("/note-store", "API\Notes\Notes@store");
      Route::get("/{id}", "API\Notes\Notes@show");

    Route::any("/search", "API\Notes\Notes@index");
    Route::post("/delete", "API\Notes\Notes@destroy")->middleware(['demoModeCheck']);
});


// Tasks
Route::group(['middleware' => ["auth:sanctum" ], 'prefix' => 'tasks'], function () {

    Route::post('/store', [TaskController::class, 'store']);
  
    Route::post("/update-status/{task}", [TaskController::class,"updateStatus"]);
 
    // Route::post("/task/{id}", [TaskController::class,'update']);

        Route::get("/get/assigned/{id}", [TaskController::class,'assignedTask']);
    
        Route::get('/{id?}', [TaskController::class, 'singletask']);

        // Route::get('/all/paginated', [TaskController::class, 'indexPaginated']);
        // Route::get('/all/dropdown', [TaskController::class, 'indexDropdown']);
    
    
        Route::post('/all/paginated', [TaskController::class, 'indexPaginated']);
        Route::post('/all/dropdown', [TaskController::class, 'indexDropdown']);
    


    Route::get("/all/status", [TaskController::class,"getStatus"]);

    Route::get("/single/status/{id}", [TaskController::class,"SingleStatus"]);

    Route::post("/update/{id}", [TaskController::class,"update"]);

    Route::post("/{task}/update-status", [TaskController::class,"updateStatus"]);

    Route::delete('/delete/{task}', [TaskController::class, 'destroy']);
   
    Route::post("/{task}/update-assigned", [TaskController::class,"updateAssigned"])->where('task', '[0-9]+');
    Route::post("/{task}/attach-files", [TaskController::class,"attachFiles"])->where('task', '[0-9]+');
    
    Route::get("/{task}/get/attach-files", [TaskController::class,"showAttachments"])->where('task', '[0-9]+');
  





    // Route::post('update-task/{id}',"TaskController@update_task_status");
    // Route::get('/{id?}',"TaskController@indexUnAllocated");
    // Route::post("/{task}/update-status", "TaskController@updateStatus");
    // Route::post('/delete', "TaskController@destroy");


});
Route::post('/store', [TaskController::class, 'store']);
