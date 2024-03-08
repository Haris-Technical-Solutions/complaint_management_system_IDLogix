<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the notes
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Leaves;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable {

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

        //content & title
        // $html = view('pages/leaves/components/modals/show-leave', compact('leave'))->render();
        // $jsondata['dom_html'][] = array(
        //     'selector' => '#plainModalBody',
        //     'action' => 'replace',
        //     'value' => $html);
        // $jsondata['dom_html'][] = array(
        //     'selector' => '#plainModalTitle',
        //     'action' => 'replace',
        //     'value' => safestr($leave['leave_title']));

         //render the form
        $html = view('pages/leaves/components/modals/add-edit-inc', compact('page', 'leave'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html);
        //show modal footer
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');
 $jsondata['postrun_functions'][] = [
                'value' => 'nxMainContentFloating',
            ];
        //ajax response
        return response()->json($jsondata);

    }

}
