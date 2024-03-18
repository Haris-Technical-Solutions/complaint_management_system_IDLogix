<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for tasks
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use Log;

class TaskAssignedRepository {

    /**
     * The assigned repository instance.
     */
    protected $assigned;

    /**
     * Inject dependecies
     */
    public function __construct(TaskAssigned $assigned) {
        $this->assigned = $assigned;
    }

    /**
     * assigned new users to a task
     * @param int $task_id the id of the project
     * @param int $user_id if specified, only this user will be assigned
     * @return bool
     */
    public function add($task_id = '', $user_id = '') {

        $list = [];

        //validations
        if (!is_numeric($task_id)) {
            Log::error("validation error - invalid params", ['process' => '[TaskAssignedRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return $list;
        }

        //add only to the specified user
        if (is_numeric($user_id)) {
            $assigned = new $this->assigned;
            $assigned->tasksassigned_taskid = $task_id;
            $assigned->tasksassigned_userid = $user_id;
            $assigned->save();
            $list[] = $user_id;
            //return array of users
            return $list;
        }

        //[team] - add each user in the post request
        if (request()->filled('assigned')) {
            foreach (request('assigned') as $user) {
                $assigned = new $this->assigned;
                $assigned->tasksassigned_taskid = $task_id;
                $assigned->tasksassigned_userid = $user;
                $assigned->save();
                //save to list
                $list[] = $user;
            }
        }

        //[client] - add each user in the post request
        if (request()->filled('assigned-client')) {
            foreach (request('assigned-client') as $user) {
                $assigned = new $this->assigned;
                $assigned->tasksassigned_taskid = $task_id;
                $assigned->tasksassigned_userid = $user;
                $assigned->save();
                //save to list
                $list[] = $user;
            }
        }

        return $list;
    }

    /**
     * get all useers assigned to a task
     * @param int $id the id of the resource
     * @return object
     */
    public function getAssigned($id = '') {

        //validations
        if (!is_numeric($id)) {
            return [];
        }

        $query = $this->assigned->newQuery();
        $query->leftJoin('users', 'users.id', '=', 'tasks_assigned.tasksassigned_userid');
        $query->where('tasksassigned_taskid', $id);
        $query->orderBy('first_name', 'ASC');
        return $query->get();
    }

 /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object task collection
     */
    public function search($id = '', $data = []) {

        $tasks = new \App\Models\Task();
        $tasks = $tasks->newQuery();
        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //joins
        $tasks->leftJoin('projects', 'projects.project_id', '=', 'tasks.task_projectid');
        $tasks->leftJoin('milestones', 'milestones.milestone_id', '=', 'tasks.task_milestoneid');
        $tasks->leftJoin('tasks_assigned', 'tasks.task_id', '=', 'tasks_assigned.tasksassigned_taskid');
        $tasks->leftJoin('users', 'users.id', '=', 'tasks_assigned.tasksassigned_userid');
        $tasks->leftJoin('clients', 'clients.client_id', '=', 'projects.project_clientid');
        $tasks->leftJoin('tasks_status', 'tasks_status.taskstatus_id', '=', 'tasks.task_status');
         $tasks->where('users.type','team');
        //join: users reminders - do not do this for cronjobs
        if (auth()->check()) {
            $tasks->leftJoin('reminders', function ($join) {
                $join->on('reminders.reminderresource_id', '=', 'tasks.task_id')
                    ->where('reminders.reminderresource_type', '=', 'task')
                    ->where('reminders.reminder_userid', '=', auth()->id());
            });
        }

        //my id
        $myid = auth()->id();

        // all client fields
        $tasks->selectRaw("*,concat(first_name,' ',last_name) as full_name");

        //count unread notifications
        $tasks->selectRaw('(SELECT COUNT(*)
                                      FROM events_tracking
                                      LEFT JOIN events ON events.event_id = events_tracking.eventtracking_eventid
                                      WHERE eventtracking_userid = ' . auth()->id() . '
                                      AND events_tracking.eventtracking_status = "unread"
                                      AND events.event_parent_type = "task"
                                      AND events.event_parent_id = tasks.task_id
                                      AND events.event_item = "comment")
                                      AS count_unread_comments');

        //count unread notifications
        $tasks->selectRaw('(SELECT COUNT(*)
                                      FROM events_tracking
                                      LEFT JOIN events ON events.event_id = events_tracking.eventtracking_eventid
                                      WHERE eventtracking_userid = ' . auth()->id() . '
                                      AND events_tracking.eventtracking_status = "unread"
                                      AND events.event_parent_type = "task"
                                      AND events.event_parent_id = tasks.task_id
                                      AND events.event_item = "attachment")
                                      AS count_unread_attachments');

        //sum all timers for this task
        $tasks->selectRaw('(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id)
                                           AS sum_all_time');

        //sum my timers for this task
        $tasks->selectRaw("(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id
                                           AND timer_creatorid = $myid)
                                           AS sum_my_time");

        //sum invoiced time
        $tasks->selectRaw("(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id
                                           AND timer_billing_status = 'invoiced')
                                           AS sum_invoiced_time");

        //sum not invoiced time
        $tasks->selectRaw("(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id
                                           AND timer_billing_status = 'not_invoiced')
                                           AS sum_not_invoiced_time");

        //default where
        $tasks->whereRaw("1 = 1");

        //filter for active or archived (default to active) - do not use this when a task id has been specified
        if (!is_numeric($id)) {
            if (!request()->filled('filter_show_archived_tasks') && !request()->filled('filter_task_state')) {
                $tasks->where('task_active_state', 'active');
            }
        }
        //  $tasks->where('task_id',4);
        //filters: id
        if (request()->filled('filter_task_id')) {
            $tasks->where('task_id', request('filter_task_id'));
        }
        if (is_numeric($id)) {
            $tasks->where('task_id', $id);
        }

        //do not show items that not yet ready (i.e exclude items in the process of being cloned that have status 'invisible')
        $tasks->where('task_visibility', 'visible');

        $tasks->where('task_status','!=' ,2);

        //by default, show only project tasks
        if (request('filter_project_type') == 'project') {
            $tasks->where('task_projectid', '>', 0);
        }

        //apply filters
        if ($data['apply_filters']) {

            //filter archived tasks
            if (request()->filled('filter_task_state') && (request('filter_task_state') == 'active' || request('filter_task_state') == 'archived')) {
                $tasks->where('task_active_state', request('filter_task_state'));
            }

            //filter clients
            if (request()->filled('filter_task_clientid')) {
                $tasks->where('task_clientid', request('filter_task_clientid'));
            }

            //filter: added date (start)
            if (request()->filled('filter_task_date_start_start')) {
                $tasks->whereDate('task_date_start', '>=', request('filter_task_date_start_start'));
            }

            //filter: added date (end)
            if (request()->filled('filter_task_date_start_end')) {
                $tasks->whereDate('task_date_start', '<=', request('filter_task_date_start_end'));
            }

            //filter: due date (start)
            if (request()->filled('filter_task_date_due_start')) {
                $tasks->whereDate('task_date_due', '>=', request('filter_task_date_due_start'));
            }

            //filter: start date (end)
            if (request()->filled('filter_task_date_due_end')) {
                $tasks->whereDate('task_date_due', '<=', request('filter_task_date_due_end'));
            }

            //filter milestone id
            if (request()->filled('filter_task_milestoneid')) {
                $tasks->where('task_milestoneid', request('filter_task_milestoneid'));
            }

            //filter: only tasks visible to the client
            if (request()->filled('filter_task_client_visibility')) {
                $tasks->where('task_client_visibility', request('filter_task_client_visibility'));
            }

            //resource filtering
            if (request()->filled('taskresource_id')) {
                $tasks->where('task_projectid', request('taskresource_id'));
            }

            //filter single task status
            if (request()->filled('filter_single_task_status')) {
                $tasks->where('task_status', request('filter_single_task_status'));
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-in-progress') {
                $tasks->where('task_status', 'in_progress');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-testing') {
                $tasks->where('task_status', 'testing');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-awaiting-feedback') {
                $tasks->where('task_status', 'awaiting_feedback');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-completed') {
                $tasks->where('task_status', 'completed');
            }

            //filter: only tasks visible to the client - as per project permissions
            if (request()->filled('filter_as_per_project_permissions')) {
                $tasks->where('clientperm_tasks_view', 'yes');
            }

            //filter: project
            if (request()->filled('filter_task_projectid')) {
                $tasks->where('task_projectid', request('filter_task_projectid'));
            }

            //filter status
            if (is_array(request('filter_tasks_status')) && !empty(array_filter(request('filter_tasks_status')))) {
                $tasks->whereIn('task_status', request('filter_tasks_status'));
            }

            //filter project
            if (is_array(request('filter_task_projectid'))) {
                $tasks->whereIn('task_projectid', request('filter_task_projectid'));
            }

            //filter priority
            if (is_array(request('filter_task_priority')) && !empty(array_filter(request('filter_task_priority')))) {
                $tasks->whereIn('task_priority', request('filter_task_priority'));
            }

            //filter assigned
            if (is_array(request('filter_assigned')) && !empty(array_filter(request('filter_assigned')))) {
                $tasks->whereIn('users.id', request('filter_assigned'));
                
                            
            }
             //filter Un-Assigned Only
             if (request()->filled('worklog') ) {
                if(strtolower(request('worklog')) == 'unallocated' ){
                    $tasks->doesntHave('assigned');
                }
                else if(strtolower(request('worklog')) == 'allocated' ){
                     $tasks->has('assigned');
                }
            }

            //filter: tags
            if (is_array(request('filter_tags')) && !empty(array_filter(request('filter_tags')))) {
                $tasks->whereHas('tags', function ($query) {
                    $query->whereIn('tag_title', request('filter_tags'));
                });
            }

            //filter my tasks (using the actions button)
            if (request()->filled('filter_my_tasks')) {
                $tasks->whereHas('assigned', function ($query) {
                    $query->whereIn('tasksassigned_userid', [auth()->id()]);
                });
            }
               //only public or users own private leaves
        if (request()->filled('calander') && request('calander')=='my' ) {
          $tasks->whereIn('tasksassigned_userid', [auth()->id()]);
                
        }
       
           
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $tasks->where(function ($query) {
                $query->Where('task_id', '=', request('search_query'));
                $query->orWhere('task_date_start', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('task_date_due', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('task_title', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('task_priority', '=', request('search_query'));
                //$query->orWhereRaw("YEAR(task_date_start) = ?", [request('search_query')]); //example binding - buggy
                //$query->orWhereRaw("YEAR(task_date_due) = ?", [request('search_query')]); //example binding  - buggy

                $query->orWhere('taskstatus_title', '=', request('search_query'));
                $query->orWhereHas('tags', function ($q) {
                    $q->where('tag_title', 'LIKE', '%' . request('search_query') . '%');
                });
                $query->orWhereHas('assigned', function ($q) {
                    $q->where('first_name', '=', request('search_query'));
                    $q->where('last_name', '=', request('search_query'));
                });
            });
        }
 
        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('tasks', request('orderby'))) {
                $tasks->orderBy(request('orderby'), request('sortorder'));
              
            }
            //others
            switch (request('orderby')) {
            case 'project':
                $tasks->orderBy('project_title', request('sortorder'));
                break;
            case 'time':
                $tasks->orderBy('timers_sum', request('sortorder'));
                break;
            case 'first_name':
               
                $tasks->orderBy('first_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            if (request('query_type') == 'kanban') {
                $tasks->orderBy('task_position', 'asc');
            } else {
                $tasks->orderBy('task_id', 'desc');
            }
        }

        //eager load
        $tasks->with([
            'tags',
            'timers',
            // 'assigned',
            'projectmanagers',
        ]);

        //count relationships
        $tasks->withCount([
            'tags',
            'comments',
            'attachments',
            'timers',
            'checklists',
        ]);

        //stats - count all
        if (isset($data['stats']) && in_array($data['stats'], [
            'count-in-progress',
            'count-testing',
            'count-awaiting-feedback',
            'count-completed',
        ])) {
            return $tasks->count();
        }

        // Get the results and return them.
        if (request('query_type') == 'kanban') {
            //return $tasks->paginate(config('system.settings_system_kanban_pagination_limits'));
            return $tasks->paginate(1000); //temporary solution until a better one
        }else if (request('per_page')=='all') {
              return $tasks->paginate(100000);
         }
        else {
            return $tasks->paginate(config('system.settings_system_pagination_limits'));
        }
    }

   
    /**
     * Bulk delete tags
     * @param string $ref_type type of tags. e.g. client|project etd
     * @param int $ref_id the id of the resource
     * @return bool
     */
    public function delete($task_id = '') {

        //validations
        if (!is_numeric($task_id)) {
            Log::error("record could not be found ", ['process' => '[TaskAssignedRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'task_id' => $task_id ?? '']);
            return false;
        }

        $assigned = $this->assigned->newQuery();
        $assigned->where('tasksassigned_taskid', $task_id);
        $assigned->delete();
    }

}