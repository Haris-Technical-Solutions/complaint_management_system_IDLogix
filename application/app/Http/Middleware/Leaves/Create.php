<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [create] precheck processes for leaves
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Leaves;
use Closure;
use Log;

class Create {

    

    /**
     * Inject any dependencies here
     *
     */
    public function __construct() {

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

        //[project] - does user have 'project level' viewing permissions
        // if (request('leaveresource_type') == 'company') {
             if (auth()->user()->is_management || auth()->user()->is_admin) {
                return $next($request);
             }
        // }

        //permission: show only the users own leaves
        // if (request('leaveresource_type') == 'user') {
            if (request('leaveresource_id') == auth()->id()) {
                return $next($request);
            }
        // }

        
        //permission denied
        Log::error("permission denied", ['process' => '[permissions][files][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
