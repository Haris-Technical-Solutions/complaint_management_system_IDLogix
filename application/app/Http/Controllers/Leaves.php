<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for leaves
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\Leaves\CreateResponse;
use App\Http\Responses\Leaves\DestroyResponse;
use App\Http\Responses\Leaves\EditResponse;
use App\Http\Responses\Leaves\IndexResponse;
use App\Http\Responses\Leaves\ShowResponse;
use App\Http\Responses\Leaves\StoreResponse;
use App\Http\Responses\Leaves\UpdateResponse;
use App\Permissions\LeavePermissions;
use App\Repositories\CategoryRepository;
use App\Repositories\LeaveRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Rules\NoTags;
use Illuminate\Http\Request;
use Validator;
use App\Repositories\EventRepository;
use App\Repositories\EventTrackingRepository;

class Leaves extends Controller {

    /**
     * The Leave repository instance.
     */
    protected $leaverepo;

    /**
     * The tags repository instance.
     */
    protected $tagrepo;

    /**
     * The user repository instance.
     */
    protected $userrepo;
    /**
     * The event repository instance.
     */
    protected $eventrepo;
     /**
     * The event tracking repository instance.
     */
    protected $trackingrepo;
    /**
     * The leave permission instance.
     */
    protected $leavepermissions;

    public function __construct(
        leaveRepository $leaverepo,
        TagRepository $tagrepo,
        UserRepository $userrepo,
        leavePermissions $leavepermissions,
        EventRepository $eventrepo,
        EventTrackingRepository $trackingrepo) {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        $this->middleware('leavesMiddlewareIndex')->only([
            'index',
            'store',
        ]);

        $this->middleware('leavesMiddlewareCreate')->only([
            'create',
            'store',
        ]);

        $this->middleware('leavesMiddlewareShow')->only([
            'show',
        ]);

        $this->middleware('leavesMiddlewareEdit')->only([
            'edit',
            'update',
        ]);

        $this->middleware('leavesMiddlewareDestroy')->only([
            'destroy',
        ]);

        $this->leaverepo = $leaverepo;

        $this->tagrepo = $tagrepo;

        $this->userrepo = $userrepo;

        $this->leavepermissions = $leavepermissions;
        $this->eventrepo = $eventrepo;
        $this->trackingrepo = $trackingrepo;

    }

    /**
     * Display a listing of leaves
     * @param object CategoryRepository instance of the repository
     * @return blade view | ajax view
     */
    public function index(CategoryRepository $categoryrepo) {
        // return auth()->user()->role_id;
        //default to user leaves if type is not set
        if (request('leaveresource_type')) {
            $page = $this->pageSettings('leaves');
        } else {
            $page = $this->pageSettings('leaves');
        }
        $leaves = $this->leaverepo->search();        
        //  request()->merge([
        //         'filter_leave_type' => 'Holiday',
        //     ]);
        // //get leaves
        // $holidays_leaves = $this->leaverepo->search();
        //  request()->merge([
        //         'filter_leave_type' => 'Sickness',
        //     ]);
        
        // $sickness_leaves = $this->leaverepo->search();
        
        $leaves_withtypes = array();

        $l_sickness = ['title'=>request('leave_type'),'leaves'=>$leaves];
        // $l_holiday = ['title'=>'Holiday','leaves'=>$holidays_leaves];
        $leaves_withtypes [] =$l_sickness;
        // $leaves_withtypes [] =$l_holiday;
        // return $leaves;
        //apply some permissions
        if ($leaves) {
            foreach ($leaves as $leave) {
                $this->applyPermissions($leave);
            }
        }

        //reponse payload
        $payload = [
            'page' => $page,
            'leaves' => $leaves,
            'leaves_withtypes' => $leaves_withtypes,
            'stats' => array(),
        ];

        //show the view
        return new IndexResponse($payload);
    }

    /**
     * Show the form for creating a new  leave
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function create() {

        //get tags
        // $tags = $this->leaverepo->getByType('leaves');
        
        //reponse payload
        $payload = [
            'page' => $this->pageSettings('create'),
            
        ];
        //  return 'asd';
        //show the form
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created leave in storage.
     * @return \Illuminate\Http\Response
     */
    public function store() {
// return 'jkl';
        $messages = [];
     
        //validate
        $validator = Validator::make(request()->all(), [
            'leave_title' => [
                'required',
                new NoTags,
            ],
            // 'leave_reason' => 'required',
            'leave_start_date' => 'required',
            // 'leave_end_date' => 'required',
            
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        //create the leave
        if (!$leave_id = $this->leaverepo->create()) {
            abort(409);
        }
   //get the leave object (friendly for rendering in blade template)
        $leaves = $this->leaverepo->search($leave_id);
        $u_request =$leaves->first();
      $l_sickness = ['title'=>request('leave_type'),'leaves'=>$leaves];
        // $l_holiday = ['title'=>'Holiday','leaves'=>$holidays_leaves];
        $leaves_withtypes [] =$l_sickness;
        
        
     
        //permissions
        $this->applyPermissions($u_request);

        //counting rows
        $leaves = $this->leaverepo->search();
        $count = $leaves->total();


        /** ----------------------------------------------
         * record event [Leave created]
         * ----------------------------------------------*/
        $data = [
            'event_creatorid' => auth()->id(),
            'event_item' => 'new_request',
            'event_item_id' => '',
            'event_item_lang' => 'added_new_'.$u_request->leave_type.'_request',
            'event_item_content' => $u_request->leave_title,
            'event_item_content2' => $u_request->leave_type,
            'event_parent_type' => 'request',
            'event_parent_id' => $u_request->leave_id,
            'event_parent_title' => $u_request->leave_title,
            'event_show_item' => 'yes',
            'event_show_in_timeline' => 'yes',
            // 'event_clientid' => $u_request->project_clientid,
            'eventresource_type' => 'request_'.$u_request->leave_type,
            'eventresource_id' => $u_request->leave_id,
            'event_notification_category' => 'notifications_request_activity',
        ];
        //record event
        if ($event_id = $this->eventrepo->create($data)) {
            //get users
            // $users = $this->userrepo->getClientUsers($project->project_clientid, 'all', 'ids');
            //record notification
            // $emailusers = $this->trackingrepo->recordEvent($data, $users, $event_id);
        }


        //reponse payload
        $payload = [
            'leaves' => $leaves,
            'count' => $count,
            
            'leaves_withtypes' => $leaves_withtypes,
        ];

        //process reponse
        return new StoreResponse($payload);

    }

    /**
     * display a leave via ajax modal
     * @param int $id leave id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->index();
        //get the leave
        $leave = $this->leaverepo->search($id);

        //leave not found
        if (!$leave = $leave->first()) {
            abort(409, __('lang.leave_not_found'));
        }

        //reponse payload
        $payload = [
            'leave' => $leave,
             'page' => $this->pageSettings('edit'),
        ];

        //process reponse
        return new ShowResponse($payload);
    }
    /**
     * Show the form for editing the specified  leave
     * @param int $id leave id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
// return request();
        //get the leave
        $leave = $this->leaverepo->search($id);


        //leave not found
        if (!$leave = $leave->first()) {
            abort(409, __('lang.leave_not_found'));
        }

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('edit'),
            'leave' => $leave,
            // 'tags' => $tags,
        ];

        //response
        return new EditResponse($payload);
    }

    /**
     * Update the specified leave in storage.
     * @param int $id leave id
     * @return \Illuminate\Http\Response
     */
    public function update($id) {
    //  return 'kl';
        //custom error messages
        $messages = [];
        $old_leave = \App\Models\Leave::find($id);
        
    
        //validate
        $validator = Validator::make(request()->all(), [
            'leave_title' => [
                'required',
                new NoTags,
            ],
            // 'leave_reason' => 'required',
            'leave_start_date' => 'required',
            'leave_end_date' => 'required',
            
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        //update
        if (!$this->leaverepo->update($id)) {
            abort(409);
        }

        //get leave
        $leaves =  \App\Models\Leave::where('leave_id',$id)->get();
          $l_sickness = ['title'=>request('leave_type'),'leaves'=>$leaves];
        // $l_holiday = ['title'=>'Holiday','leaves'=>$holidays_leaves];
        $leaves_withtypes [] =$l_sickness;
        
        $u_request =   \App\Models\Leave::find($id);
       
       // return  $u_request;
        $this->applyPermissions($u_request);
        

         /** ----------------------------------------------
         * record event [Leave created]
         * ----------------------------------------------*/
         if($old_leave->leave_status!=$u_request->leave_status){
            $data = [
                'event_creatorid' => auth()->id(),
                'event_item' => 'status',
                'event_item_id' => '',
                'event_item_lang' => $u_request->leave_type.'_request_status_changed',
                'event_item_content' => $u_request->leave_status,
                'event_item_content2' => $u_request->leave_type,
                'event_parent_type' => 'request',
                'event_parent_id' => $u_request->leave_id,
                'event_parent_title' => $u_request->leave_title,
                'event_show_item' => 'yes',
                'event_show_in_timeline' => 'yes',
                // 'event_clientid' => $u_request->project_clientid,
                'eventresource_type' => 'request_'.$u_request->leave_type,
                'eventresource_id' => $u_request->leave_id,
                'event_notification_category' => 'notifications_request_activity',
            ];
            //record event
            if ($event_id = $this->eventrepo->create($data)) {
                //get users
                // $users = $this->userrepo->getClientUsers($project->project_clientid, 'all', 'ids');
                //record notification
                // $emailusers = $this->trackingrepo->recordEvent($data, $users, $event_id);
            }
        }
        //reponse payload
        $payload = [
            'leaves' => $leaves,
            
            'leaves_withtypes' => $leaves_withtypes,
        ];

        //generate a response
        return new UpdateResponse($payload);
    }

    /**
     * Remove the specified leave from storage.
     * @param int $id leave id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $leave = \App\Models\Leave::Where('leave_id', $id)->first();

        //remove the item
        $leave->delete();

        //reponse payload
        $payload = [
            'leave_id' => $id,
        ];

        //generate a response
        return new DestroyResponse($payload);
    }

    /**
     * pass the file through the ProjectPermissions class and apply user permissions.
     * @param object leave instance of the leave model object
     * @return object
     */
    private function applyPermissions($leave = '') {

        //sanity - make sure this is a valid file object
        if ($leave instanceof \App\Models\Leave) {
            //delete permissions
            $leave->permission_edit_delete_leave = $this->leavepermissions->check('edit-delete', $leave);
        }
    }
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.leaves'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'leaves',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_leaves' => 'active',
            'sidepanel_id' => 'sidepanel-filter-leaves',
            'dynamic_search_url' => url('leaves/search?action=search&leave_type=' . request('leave_type')),
            'add_button_classes' => 'add-edit-leave-button',
            'load_more_button_route' => 'leaves',
            'source' => 'list',
        ];

        //default modal settings (modify for sepecif sections)
        $page += [
            'add_modal_title' => __('lang.add_leave'),
            'add_modal_create_url' => url('leaves/create?leave_type=' . request('leave_type').'&leaveresource_id='.auth()->id()),
            'add_modal_action_url' => url('leaves?leave_type=' . request('leave_type')),
            'add_modal_action_ajax_class' => '',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //leaves list page
        if ($section == 'leaves') {
            $page += [
                'meta_title' => __('lang.leaves'),
                'heading' => __('lang.leaves'),
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //leaves list my leaves
        if ($section == 'myleaves') {
            $page += [
                'meta_title' => __('lang.my_leaves'),
                'heading' => __('lang.my_leaves'),
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //leave page
        if ($section == 'leave') {
            //adjust
            $page['page'] = 'leave';
            //add
            $page += [
                'crumbs' => [
                    __('lang.leaves'),
                ],
                'meta_title' => __('lang.leaves'),
                'leave_id' => request()->segment(2),
                'section' => 'overview',
            ];
            //ajax loading and tabs
            $page += $this->setActiveTab(request()->segment(3));
            return $page;
        }

        //create new resource
        if ($section == 'create') {
            $page += [
                'section' => 'create',
            ];
            return $page;
        }

        //edit new resource
        if ($section == 'edit') {
            $page += [
                'section' => 'edit',
            ];
            return $page;
        }

        //return
        return $page;
    }

}