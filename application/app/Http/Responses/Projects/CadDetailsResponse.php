<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [details] process for the projects
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Projects;
use Illuminate\Contracts\Support\Responsable;

class CadDetailsResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for team members
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
        $html = view('pages/project/components/tabs/caddetails', compact('page', 'project', 'categories','contacts', 'tags', 'fields','cadstatuses','bim_statuses','topo_qa_approval','topo_report','topo_survey','utility_qa_approval','utiltiysurveyreport'))->render();
        // $html = view('pages/projects/components/modals/add-edit-inc', compact('page', 'project', 'categories','contacts', 'tags', 'fields'))->render();
     
        $jsondata['dom_html'][] = [
            'selector' => '#embed-content-container',
            'action' => 'replace',
            'value' => $html,
        ];

        //for embed -change active tabs menu
        $jsondata['dom_classes'][] = [
            'selector' => '.tabs-menu-details',
            'action' => 'remove',
            'value' => 'active',
        ];

    

        //for embed -change active tabs menu
        
            $jsondata['dom_classes'][] = [
            'selector' => '#tabs-menu-cad-details',
            'action' => 'add',
            'value' => 'active',
            ];
        
       


        //change actions right panel
        $html = view('pages/project/components/misc/actions', compact('page', 'project'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#list-page-actions-container',
            'action' => 'replace-with',
            'value' => $html,
        ];
        
        if(request('cad_form'))
            $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        // POSTRUN FUNCTIONS------
        // if (config('visibility.edit_project_button')) {
            $jsondata['postrun_functions'][] = [
                'value' => 'NXProjectDetails',
            ];
        // }

        //ajax response
        return response()->json($jsondata);
    }

}
