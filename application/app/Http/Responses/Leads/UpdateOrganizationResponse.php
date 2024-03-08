<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [update status] process for the leads
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Leads;
use Illuminate\Contracts\Support\Responsable;

class UpdateOrganizationResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for leads
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

          //render the form
        $html = view('pages/leads/components/actions/show-map', compact('lead'))->render();
        if(@request('ref')=='detail')
        $selector='#embed-content-container';
        else
        $selector='#plainModalBody';
        
        $jsondata['dom_html'][] = array(
            'selector' => $selector,
            'action' => 'replace',
            'value' => $html);
        $jsondata['dom_html'][] = array(
            'selector' => '#plainModalTitle',
            'action' => 'replace',
            'value' => 'Site Location');   
            
        $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');
        //update error
        if (isset($error) && isset($message)) {
            $jsondata['notification'] = [
                'type' => 'error',
                'value' => $message,
            ];
        }else{
            //notice
            $jsondata['notification'] = array('type' => 'success', 'value' => __('Address Updated'));

        }

        //response
        return response()->json($jsondata);

    }

}
