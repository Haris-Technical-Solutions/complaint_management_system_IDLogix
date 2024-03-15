<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for files
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\API\FileGroups;
use App\Http\Controllers\Leads;
use App\Http\Controllers\Controller;
use App\Http\Responses\FileGroups\CreateResponse;
use App\Http\Responses\FileGroups\DestroyResponse;
use App\Http\Responses\FileGroups\IndexResponse;
use App\Http\Responses\FileGroups\StoreResponse;
use App\Http\Responses\FileGroups\ShowFoldersResponse;
use App\Http\Responses\FileGroups\UpdateResponse;
use App\Http\Responses\FileGroups\EditFoldersResponse;
use App\Permissions\FilePermissions;
use App\Permissions\ProjectPermissions;
use App\Repositories\AttachmentRepository; 
use App\Repositories\DestroyRepository;
use App\Repositories\EmailerRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventTrackingRepository;
use App\Repositories\FileGroupRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class FileGroupsController extends Controller {
  
    /**
     * The file group repository instance.
     */
    protected $filegrouprepo;

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
     * The resources that are associated with files (e.g. project | lead | client)
     */
    protected $approved_resources;

    /**
     * The emailer repository
     */
    protected $emailerrepo;

    public function __construct(
        FileGroupRepository $filegrouprepo,
       
        UserRepository $userrepo,
        EventRepository $eventrepo,
        EventTrackingRepository $trackingrepo
      
    ) {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        //route middleware
        $this->middleware('filesMiddlewareIndex')->only([
            // 'index',
            // 'store',
            'renameFile',
        ]);

        $this->middleware('filesMiddlewareCreate')->only([
            'create',
            'store',
        ]);

        $this->middleware('filesMiddlewareDownload')->only([
            'download',
        ]);

        $this->middleware('filesMiddlewareDestroy')->only([
            'destroy',
        ]);

        $this->middleware('filesMiddlewareEdit')->only(
            [
                'edit',
                'renameFile',
            ]);
        $this->filegrouprepo= $filegrouprepo;
    
        $this->userrepo = $userrepo;

        $this->eventrepo = $eventrepo;
        $this->trackingrepo = $trackingrepo;
    
        //allowable resource_types
        $this->approved_resources = [
            'project',
            'lead',
            'client',
        ];
    }

    /**
     * Display a listing of files
     * @return \Illuminate\Http\Response
     */
    public function index() {
 
        $filegroups = $this->filegrouprepo->search();

        //apply some permissions
        if ($filegroups) {
            foreach ($filegroups as $filegroup) {
                $this->applyPermissions($filegroup);
            }
        }

        //mark events as read
        if (request()->filled('file_group_source_type') && request()->filled('file_group_source_id')) {
            \App\Models\EventTracking::where('resource_id', request('file_group_source_id'))
                ->where('resource_type', request('file_group_source_type'))
                ->where('eventtracking_userid', auth()->id())
                ->update(['eventtracking_status' => 'read']);
        }

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('filegroups'),
            'filegroups' => $filegroups,
            
        ];

        
        // return $payload;
        //show the view
        return new IndexResponse($payload);
    }

    /**
     * Additional settings for external requests
     */
    public function externalRequest() {

        //check we have a file id and type
        if (!is_numeric(request('project_id'))) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }
    }

    /**
     * Show the form for creating a new file.
     * @return \Illuminate\Http\Response
     */
    public function create() {

        //validate the incoming request
        if (!is_numeric(request('resource_id')) || !in_array(request('resource_type'), $this->approved_resources)) {
            //hide the add button
            request()->merge([
                'visibility_list_page_actions_add_button' => false,
            ]);
        }

        //payload
        $payload = [];

        //show the view
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created file in storage.
     * @return \Illuminate\Http\Response
     */
    public function store() {

    //  return 'asd';
        //defaults
        $file_clientid = null;
    //    return request();
        //validation
        if (!is_numeric(request('fileresource_id')) || !in_array(request('fileresource_type'), $this->approved_resources)) {
            //error
            // return 'sad';
            abort(409, __('lang.error_request_could_not_be_completed'));
        }
         //custom error messages
         $messages = [
            'filefolder_name.required' => __('lang.folder_name') . ' - ' . __('lang.is_required'),
        ];

         //validate
         $validator = Validator::make(request()->all(), [
            'filefolder_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (request()->filled('filefolder_name')) {
                        if (\App\Models\FileGroup::Where('file_group_name', $value)->Where('file_group_resource_id', request('fileresource_id'))
                        ->Where('file_group_resource_type', request('fileresource_type'))->exists()) {
                            return $fail(__('lang.folder_name') . ' - ' . __('lang.already_exists'));
                        }
                    }
                },
            ],
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

        //store record
        $folder = new \App\Models\FileGroup();
        $folder->file_group_creator_id = auth()->id();
        $folder->file_group_name = request('filefolder_name');
        $folder->file_group_resource_id = request('fileresource_id');
        $folder->file_group_resource_type = request('fileresource_type');
        // return 'sad';
        $folder->save();

        //counting rows
        $rows = $this->filegrouprepo->search();
        $count = $rows->total();

        //[save attachments] loop through and save each attachment
        $filegroups = $this->filegrouprepo->search();

        //apply some permissions
        if ($filegroups) {
            foreach ($filegroups as $filegroup) {
                $this->applyPermissions($filegroup);
            }
        }

       return $payload = [
            'page' => $this->pageSettings('filegroups'),
            'folders' => $rows,
            'count' => $count,
        ];
        
        //show the view
        return new StoreResponse($payload);
    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $filegroup = \App\Models\FileGroup::Where('filegroup_id', $id)->first();

        //page
        $html = view('pages/files/components/actions/rename', compact('payload'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#actionsModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        $jsondata['dom_visibility'][] = [
            'selector' => '#actionsModalFooter', 'action' => 'show',
        ];

        //render
        return response()->json($jsondata);

    }
    /**
     * Show the resource
     * @return blade view | ajax view
     */
    public function show() {

        $folders = \App\Models\FileGroup::Where('file_group_resource_id', request('fileresource_id'))->Where('file_group_resource_type', request('fileresource_type'))->orderBy('file_group_name', 'asc')->get();

        $payload = [
            'folders' => $folders,
            'page' => $this->pageSettings('filegroups'),
            'fileresource_id' => request('fileresource_id'),
            'fileresource_type' =>  request('fileresource_type')
        ];

        //return the reposnse
        return new EditFoldersResponse($payload);

    }
    /**
     * Show the resource
     * @return blade view | ajax view
     */
    public function showlist() {

        $folders = \App\Models\FileGroup::Where('file_group_resource_id', request('fileresource_id'))->Where('file_group_resource_type', request('fileresource_type'))->orderBy('file_group_name', 'asc')->get();
 $folders = $this->filegrouprepo->search();
        $payload = [
            'folders' => $folders,
            
            'page' => $this->pageSettings('filegroups'),
            'fileresource_id' => request('fileresource_id'),
            'fileresource_type' =>  request('fileresource_type')
        ];

        //return the reposnse
        return new ShowFoldersResponse($payload);

    }
    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function renameFile($id) {

        //get the item
        $filegroup = \App\Models\FileGroup::Where('file_group_id', $id)->first();

        if (!request()->filled('file_group_name')) {
            abort(409, __('lang.file_group_name') . ' - ' . __('lang.is_required'));
        }

        //new filename
        $new_filename = request('file_group_name') ;

        //rename file
        try {
            $old_file = $file->file_filename;
            $new_file = $new_filename;
            rename($old_file, $new_file);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $error_code = $e->getCode();
            if ($error_code = 123) {
                abort(409, __('lang.invalid_file_group_name'));
            }
            abort(409, $message);
        }

        //update db
        $file->file_group_name = $new_filename;
        $file->save();

        //get friendly row
        $filegroups = $this->filegrouprepo->search($id);

        //apply some permissions
        if ($filegroups) {
            foreach ($filegroups as $file) {
                $this->applyPermissions($file);
            }
        }

        //payload
        $payload = [
            'files' => $filegroups,
            'file' => $filegroups->first(),
        ];

        //return view
        return new UpdateResponse($payload);

    }

    /**
     * show file image thumbs in tables
     * @return \Illuminate\Http\Response
     */
    public function showImage() {

        $image = '';

        //default image
        $default_image = 'system/images/image-placeholder.jpg';
        if (Storage::exists($default_image)) {
            $image = $default_image;
        }

        //check if file exists in the database

        //get the file from database
        if (request()->filled('file_id')) {
            if ($file = \App\Models\File::Where('file_uniqueid', request('file_id'))->first()) {
                //confirm thumb exists
                if ($file->file_thumbname != '') {
                    $image_path = "files/$file->file_directory/$file->file_thumbname";
                    if (Storage::exists($image_path)) {
                        $image = $image_path;
                    }
                }
            }
        }

        //browser image response
        if ($image != '') {
            $thumb = Storage::get($image);
            $mime = Storage::mimeType($image);
            header('Content-Type: image/gif');
            echo $thumb;
        }
    }

   
    /**
     * Update the specified file in storage.
     * @param int $id file id
     * @return \Illuminate\Http\Response
     */
    public function update() {


        if (is_array(request('file_group_name'))) {
            //validate
            foreach (request('file_group_name') as $id => $value) {
                if ($value == '') {
                    abort(409, __('lang.fill_in_all_fields'));
                }
            }
            //update
            foreach (request('file_group_name') as $id => $value) {
                \App\Models\FileGroup::where('file_group_id', $id)
                    ->update(['file_group_name' => $value]);
            }
        }

        $folders = \App\Models\FileGroup::Where('file_group_resource_id', request('fileresource_id'))->Where('file_group_resource_type', request('fileresource_type'))->orderBy('file_group_name', 'asc')->get();

        $payload = [
            'folders' => $folders,
            'page' => $this->pageSettings('filegroups'),
        ];


        //update file
        // if (!$this->filerepo->update($id)) {
        //     abort(409, __('lang.error_request_could_not_be_completed'));
        // }

        //update file timeline visibility
        // if ($event = \App\Models\Event::Where('event_item', 'folder')->Where('event_item_id', $id)->first()) {
        //     $event->event_show_in_timeline = (request('visible_to_client') == 'on') ? 'yes' : 'no';
        //     $event->save();
        // }

        //success notification - no real need to show a confirmation for this
        //return response()->json(success());
        //return the reposnse
          return new ShowFoldersResponse($payload);
    }

    /**
     * Remove the specified file from storage.
     * @param object DestroyRepository instance of the repository
     * @param int $id file id
     * @return \Illuminate\Http\Response
     */
    public function delete(DestroyRepository $destroyrepo) {
       
        //delete file
        if(!$destroyrepo->destroyFolder(request('filegroup_id'))){
            abort(409, __('File exist in folder'));
        }

        //reponse payload
        // $payload = [
        //     'file_group_id' => $id,
        // ];
      
        $folders = \App\Models\FileGroup::Where('file_group_resource_id', request('fileresource_id'))
     ->Where('file_group_resource_type', request('fileresource_type'))
     ->orderBy('file_group_name', 'asc')->get();

        $payload = [
            'folders' => $folders,
            'page' => $this->pageSettings('filegroups'),
            'fileresource_id' => request('fileresource_id'),
            'fileresource_type' =>  request('fileresource_type')
        ];


        //process reponse
        return new ShowFoldersResponse($payload);
    }

    /**
     * pass the file through the ProjectPermissions class and apply user permissions.
     * @param object $file file model
     * @return object
     */
    private function applyPermissions($file = '') {

        //sanity - make sure this is a valid file object
        if ($file instanceof \App\Models\File) {
            //project files
            if ($file->fileresource_id > 0) {
                $file->permission_delete_file = $this->filepermissions->check('delete', $file);
                $file->permission_edit_file = $this->filepermissions->check('edit', $file);
            }
            //template files
            if ($file->fileresource_id < 0) {
                $file->permission_delete_file = (auth()->user()->role->role_templates_projects >= 2) ? true : false;
                $file->permission_edit_file = (auth()->user()->role->role_templates_projects >= 2) ? true : false;
            }
        }
    }
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {
        
        $searchtype='';
        if(request('filter_file_clientid'))
        $searchtype='&filter_file_clientid='.request('filter_file_clientid');
        //common settings
        $page = [
            'crumbs' => [
                __('lang.filegroups'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'files',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_filegroups' => 'active',
            'sidepanel_id' => 'sidepanel-filter-files',
            'dynamic_search_url' => url('filegroups/search?action=search&fileresource_id=' . request('fileresource_id') . '&fileresource_type=' . request('fileresource_type').$searchtype),
            'add_button_classes' => 'add-edit-file-button',
            'load_more_button_route' => 'filegroups',
            'source' => 'list',
        ];

        //default modal settings (modify for sepecif sections)
        $url_param =     'fileresource_id=' . request('fileresource_id') . '&fileresource_type=' . request('fileresource_type');
        if(request('filegroup_id'))
        $url_param = $url_param . '&filegroup_id=' . request('filegroup_id');

        $page += [
            'add_modal_title' => __('lang.add_filegroup'),

            'add_modal_create_url' => url('filegroups/create?'.$url_param),
            'add_modal_action_url' => url('filegroups?'.$url_param),
            'add_modal_action_ajax_class' => 'js-ajax-ux-request',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //files list page
        if ($section == 'filegroups') {
            $page += [
                'meta_title' => __('lang.filegroups'),
                'heading' => __('lang.filegroups'),
                'sidepanel_id' => 'sidepanel-filter-files',
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
        }

        //create new resource
        if ($section == 'create') {
            $page += [
                'section' => 'create',
            ];
        }

        //edit new resource
        if ($section == 'edit') {
            $page += [
                'section' => 'edit',
            ];
        }

        //return
        return $page;
    }
}