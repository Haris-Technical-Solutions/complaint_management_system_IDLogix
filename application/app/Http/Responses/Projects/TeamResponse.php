<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [destroy] process for the projects
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Projects;
use Illuminate\Contracts\Support\Responsable;

class TeamResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * remove the item from the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }
        //full payload array
        $payload = $this->payload;
       
         /** -------------------------------------------------------------------------
         * show project logs
         * -------------------------------------------------------------------------*/
       
            $html = view('pages/project/components/tabs/team', compact('payload','project','page','contacts'))->render();
            
            $jsondata['dom_html'][] = [
                'selector' => '#embed-content-container',
                'action' => 'replace',
                'value' => $html,
            ];
        
            $jsondata['dom_classes'][] = [
                'selector' => '#tabs-menu-team',
                'action' => 'add',
                'value' => 'active',
            ];
        //ajax response
        return response()->json($jsondata);

    }

}
