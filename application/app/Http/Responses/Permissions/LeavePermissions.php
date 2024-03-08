<?php

namespace App\Permissions;

use App\Repositories\LeaveRepository;
use Illuminate\Support\Facades\Log;

class LeavePermissions {

    /**
     * The leave repository instance.
     */
    protected $leaverepo;
    /**
     * Inject dependecies
     */
    public function __construct(
        LeaveRepository $leaverepo
    ) {

        $this->leaverepo = $leaverepo;

    }

    /**
     * The array of checks that are available.
     * NOTE: when a new check is added, you must also add it to this array
     * @return array
     */
    public function permissionChecksArray() {
        $checks = [
            'edit-delete',
            'show',
        ];
        return $checks;
    }

    /**
     * This method checks a users permissions for a particular, specified File ONLY.
     *
     * [EXAMPLE USAGE]
     *          if (!$this->leavepermissons->check($leave_id, 'delete')) {
     *                 abort(413)
     *          }
     *
     * @param numeric $leave object or id of the resource
     * @param string $action [required] intended action on the resource se list above
     * @return bool true if user has permission
     */
    public function check($action = '', $leave = '') {

        //VALIDATIOn
        if (!in_array($action, $this->permissionChecksArray())) {
            Log::error("the requested check is invalid", ['process' => '[permissions][leave]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'check' => $action ?? '']);
            return false;
        }

        //GET THE RESOURCE
        if (is_numeric($leave)) {
            if (!$leave = \App\Models\Leave::Where('leave_id', $leave)->first()) {
                Log::error("the leave coud not be found", ['process' => '[permissions][leave]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            }
        }

        //[IMPORTANT]: any passed file object must from filerepo->search() method, not the file model
        if ($leave instanceof \App\Models\Leave || $leave instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            //all is ok
        } else {
            Log::error("the leave coud not be found", ['process' => '[permissions][leave]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        /**
         * [DOWNLOAD FILES]
         */
        if ($action == 'show') {

            //creator
            // if ($leave->leave_creatorid == auth()->id()) {
                return true;
            // }

            // //public leaves
            if ($leave->leave_visibility == 'public') {
            //     //project leave
            //     if ($leave->leaveresource_type == 'project') {
            //         //user who can view can also dowload
            //         if ($this->projectpermissons->check('leaves-view', $leave->leaveresource_id)) {
            //             return true;
            //         }
            //     }

            //     //client leave
            //     if ($leave->leaveresource_type == 'client') {
            //         if (auth()->user()->role->role_clients >= 1) {
            //             return true;
            //         }
            //     }
            }
        }

        /**
         * [EDIT OR DELETE NOTE]
         */
        if ($action == 'edit-delete') {
            //creator
            // if ($leave->leave_creatorid == auth()->id() || auth()->user()->is_management || auth()->user()->is_admin || auth()->user()->role->role_id=12) {
            // $leave->leave_creatorid == auth()->id() ||
            if ( auth()->user()->is_management || auth()->user()->is_admin || auth()->user()->role->role_id==12) {
                return true;
            }

            // //project leave
            // if ($leave->leaveresource_type == 'project') {
            //     if ($this->projectpermissons->check('super-user', $leave->leaveresource_id)) {
            //         return true;
            //     }
            // }
            // //client leave
            // if ($leave->leaveresource_type == 'client') {
            //     if (auth()->user()->role->role_clients >= 2) {
            //         return true;
            //     }
            // }
        }

        //failed
        Log::info("permissions denied on this leave", ['process' => '[permissions][files]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        return false;
    }

}