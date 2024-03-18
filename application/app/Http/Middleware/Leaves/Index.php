<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for leaves
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Leaves;

use App\Models\leave;
use App\Permissions\ProjectPermissions;
use Closure;
use Log;

class Index {

    /**
     * The project permisson repository instance.
     */
    protected $projectpermissons;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(ProjectPermissions $projectpermissons) {

        $this->projectpermissons = $projectpermissons;

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

        //permission: show only the users own leaves
        if (!request()->filled('leaveresource_type')) {
            if(auth()->user()->is_admin || auth()->user()->is_management)
                request()->merge([
                    'leaveresource_type' => 'company',
                ]);
            else
                request()->merge([
                    'leaveresource_type' => 'user',
                    'leaveresource_id' => auth()->id(),
                ]);
            
        }

        //various frontend and visibility settings
        $this->fronteEnd();

        
        //permission: show only the users own leaves
        if (request('leaveresource_type') == 'user') {
            if (request('leaveresource_id') == auth()->id()) {
                return $next($request);
            }
        }

       
        //Client leaves
        if (request('leaveresource_type') == 'company') {
            //team
             if(auth()->user()->is_admin || auth()->user()->is_management || auth()->user()->role_id==12)
                {
                    return $next($request);
                
                }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][leaves][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        /**
         * shorten resource type and id (for easy appending in blade templates)
         * [usage]
         *   replace the usual url('leave') with urlResource('leave'), in blade templated
         * */
        if (request('leaveresource_type') != '' || is_numeric(request('leaveresource_id'))) {
            request()->merge([
                'resource_query' => 'ref=list&leaveresource_type=' . request('leaveresource_type') . '&leaveresource_id=' . request('leaveresource_id'),
            ]);
        } else {
            request()->merge([
                'resource_query' => 'ref=list',
            ]);
        }

        //add project leaves
        if (request('leaveresource_type') == 'company') {
           
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            
        }


        //add users own leaves
        if (request('leaveresource_type') == 'user') {
            config([
                'visibility.list_page_actions_add_button' => true,
            ]);
        }

    }
}
