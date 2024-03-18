<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [show] precheck processes for leaves
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Leaves;
use App\Permissions\LeavePermissions;
use Closure;
use Log;

class Show {

    /**
     * The project permisson repository instance.
     */
    protected $leavepermissons;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct( LeavePermissions $leavepermissons) {
       
         $this->leavepermissons = $leavepermissons;
    }

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] files
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //basic validation
        if (!$leave = \App\Models\Leave::Where('leave_id', request()->route('leave'))->first()) {
            Log::error("leave could not be found", ['process' => '[permissions][leaves][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'leave' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'leave id' => $leave_id ?? '']);
            abort(409, __('lang.leave_not_found'));
        }

      if ($this->leavepermissons->check('show', $leave)) {
            return $next($request);
        }
        // return $next($request);
        //permission: show only the users own leaves
        if ($leave->leaveresource_type == 'user') {
            if ($leave->leaveresource_id == auth()->id()) {
                return $next($request);
            }
        }

        //permission: only team members with client editng permissions
        if ($leave->leaveresource_type == 'client') {
            if (auth()->user()->is_team) {
                if (auth()->user()->role->role_clients >= 1) {
                    return $next($request);
                }
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][files][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
