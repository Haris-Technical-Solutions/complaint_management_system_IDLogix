<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [store] process for the files
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\FileGroups;
use Illuminate\Contracts\Support\Responsable;

class ShowFoldersResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for files
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //page
        
       // $page['url'] = loadMoreButtonUrl($folders->currentPage() + 1, request('source'));
        $html = view('pages/files/components/folders/list', compact('page','folders','fileresource_id','fileresource_type'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#folders-body',
            'action' => 'replace',
            'value' => $html,
        ];

        //render
        return response()->json($jsondata);

    }

}
