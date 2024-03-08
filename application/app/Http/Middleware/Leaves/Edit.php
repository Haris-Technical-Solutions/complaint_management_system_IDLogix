<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [edit] precheck processes for leaves
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Leaves;
use App\Permissions\LeavePermissions;
use Closure;
use Log;

class Edit {

    /**
     * The leave permisson repository instance.
     */
    protected $leavepermissons;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(LeavePermissions $leavepermissons) {

        $this->leavepermissons = $leavepermissons;
    }

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] leaves
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//  dd($request->route()->parameters());
        //basic validation
        if (!$leave = \App\Models\Leave::Where('leave_id', request()->route('leave'))->first()) {
            Log::error("leave could not be found", ['process' => '[permissions][leaves][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'leave' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'leave id' => $leave_id ?? '']);
            abort(409, __('lang.leave_not_found').'---'.request()->route()->parameter);
        }

        //all
        if ($this->leavepermissons->check('edit-delete', $leave)) {
            return $next($request);
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][leaves][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'leave' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
