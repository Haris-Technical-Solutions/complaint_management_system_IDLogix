<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [status] process for the leads
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Leads;
use Illuminate\Contracts\Support\Responsable;

class ShowMapResponse implements Responsable {

    private $payload;
 
    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        
        //render the form
        $html = view('pages/leads/components/actions/show-map', compact('lead'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#plainModalBody',
            'action' => 'replace',
            'value' => $html);
        $jsondata['dom_html'][] = array(
            'selector' => '#plainModalTitle',
            'action' => 'replace',
            'value' => 'Location:'.$lead->lead_zip.' '.$lead->lead_street.' '.$lead->lead_city.' '.$lead->lead_state.' '.$lead->lead_country);   
            
        $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');


        //ajax response
        return response()->json($jsondata);

    }

}
