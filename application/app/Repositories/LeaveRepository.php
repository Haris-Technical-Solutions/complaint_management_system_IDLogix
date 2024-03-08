<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for leaves
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Leave;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Log;

class LeaveRepository {

    /**
     * The leaves repository instance.
     */
    protected $leaves;

    /**
     * Inject dependecies
     */
    public function __construct(Leave $leaves) {
        $this->leaves = $leaves;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object leave collection
     */
    public function search($id = '') {

        $leaves = $this->leaves->newQuery();

        // all client fields
        $leaves->selectRaw('*');

        //joins
        $leaves->leftJoin('users', 'users.id', '=', 'leaves.leave_creatorid');
        //joins
        $leaves->leftJoin('users as requester', 'requester.id', '=', 'leaves.leave_requester_userid');
        //default where
        $leaves->whereRaw("1 = 1");

        //filters: id
        if (request()->filled('filter_leave_id')) {
            $leaves->where('leave_id', request('filter_leave_id'));
        }
        if (is_numeric($id)) {
            $leaves->where('leave_id', $id);
        }

        //resource filtering
        // if (request()->filled('leaveresource_type') && request()->filled('leaveresource_id')) {
        //     $leaves->where('leaveresource_type', request('leaveresource_type'));
        //     $leaves->where('leaveresource_id', request('leaveresource_id'));
        // }

        //only public or users own private leaves
        if (request()->filled('leaveresource_type') && request()->filled('leaveresource_id') && request('leaveresource_type')!='Company') {
            $leaves->where(function ($query) {
            // $query->where('leave_visibility', 'public');
            $query->orWhere('leave_requester_userid', auth()->id());
        });
        }
         //only public or users own private leaves
        if (request()->filled('calander') && request('calander')=='my' ) {
            $leaves->Where('leave_requester_userid', auth()->id());
        }
       
        //only public or users own private leaves
        if (request()->filled('leave_type') ) {
            $leaves->where('leave_type', request('leave_type'));
        }
        
        //only public or users own private leaves
        if (request()->filled('leave_status') ) {
            $leaves->where('leave_status', request('leave_status'));
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
        $search_qry=request('search_query');
            $leaves->where(function ($query) {
                $query->where('leave_title', 'LIKE', '%' . request('search_query') . '%');
                 $query->orWhere('leave_start_date', 'LIKE', '%' .date('Y-m-d', strtotime(request('search_query'))). '%');
                 $query->orWhere('leave_end_date', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                 $query->orWhere('leave_status', 'LIKE', '%' . request('search_query') . '%');
                 $query->orWhereHas('requester',function($qry)  { 
                    $qry->where('first_name','LIKE', '%' . request('search_query') . '%');
                 }
                );
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('leaves', request('orderby'))) {
                $leaves->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'category':
                $leaves->orderBy('category_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $leaves->orderBy('leave_id', 'desc');
        }

        //eager load
        // $leaves->with(['tags']);

        // Get the results and return them.
        return $leaves->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $leave = new $this->leaves;

        //data
        $leave->leave_creatorid = auth()->id();
        $leave->leave_title = request('leave_title');
        $leave->leave_reason = request('leave_reason');
        $leave->leave_status = 'Pending';
        $leave->leave_requester_userid = request('leave_requester_userid')??auth()->id();
        $leave->leave_start_date = request('leave_start_date');
        $leave->leave_end_date = request('leave_end_date')??request('leave_start_date');
        $leave->leave_type = request('leave_type');
        $leave->leave_title = request('leave_type');
        $leave->department = request('department');
        
        $leave->day_to_taken = request('day_to_taken');
        //save and return id
        if ($leave->save()) {
            return $leave->leave_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[LeaveRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id leave id
     * @return bool
     */
    public function update($id) {

        //get the record
        if (!$leave = $this->leaves->find($id)) {
            Log::error("record could not be found - database error", ['process' => '[MilestoneRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'leave_id' => $id ?? '']);
            return false;
        }

        //general
        $leave->leave_title = request('leave_title');
        $leave->leave_reason = request('leave_reason');
        $leave->leave_start_date = request('leave_start_date');
        $leave->leave_end_date = request('leave_end_date');
        $leave->department = request('department');
        
        $leave->day_to_taken = request('day_to_taken');
        $leave->leave_type = request('leave_type');
        $leave->leave_status = request('leave_status');
        
        //save
        if ($leave->save()) {
            return $leave->leave_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[LeaveRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }
}