<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for files
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\FileGroup;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as Files;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Image;
use Log;

class FileGroupRepository {

    /**
     * The files repository instance.
     */
    protected $files;

    /**
     * Inject dependecies
     */
    public function __construct(FileGroup $files) {
        $this->files = $files;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object file collection
     */
    public function search($id = '', $data = []) {

        $files = $this->files->newQuery();
        
        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        // all client fields
        $files->selectRaw('*');

        //joins
        $files->leftJoin('users', 'users.id', '=', 'file_groups.file_group_creator_id');


        //default where
        $files->whereRaw("1 = 1");

        //[filter] by file id
        if (is_numeric($id)) {
            $files->where('file_group_id', $id);
        }

        //[data filter] resource_id
        if (isset($data['fileresource_id'])) {
            $files->where('file_group_resource_id', $data['fileresource_id']);
        }

        //[data filter] resource_type
        if (isset($data['fileresource_type'])) {
            $files->where('file_group_resource_type', $data['fileresource_type']);
        }

        //apply filters
        if ($data['apply_filters']) {

            //filters: id
            if (request()->filled('filter_file_group_id')) {
                $files->where('filter_file_group_id', request('filter_file_group_id'));
            }

            //filters: fileresource_type
            if (request()->filled('fileresource_type')) {
               
                 $files->where('file_group_resource_type', request('fileresource_type'));
            }

            //filters: fileresource_id
            if (request()->filled('fileresource_id')) {
                $files->where('file_group_resource_id', request('fileresource_id'));
            }

        }
        
        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $s_qry = request('search_query');
            $files->where(function ($query) {
                $query->Where('file_group_id', '=', request('search_query'));
                $query->orWhere('file_group_created', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('file_group_name', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhereHasMorph('fileresource', [Project::class], function($qry)  {
                    $qry->where('project_title', 'LIKE', '%' . request('search_query') . '%' );
                    /*$qry->orWhereHas('lead',function($l_qry){
                        $l_qry->where(, 'LIKE', '%' . request('search_query') . '%' );
                    });*/
                });
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('files', request('orderby'))) {
                $files->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'added_by':
                $files->orderBy('first_name', request('sortorder'));
                break;
            case 'visibility':
                $files->orderBy('file_visibility_client', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $files->orderBy('file_group_name', 'asc');
        }

        // Get the results and return them.
        return $files->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @param array $data payload data
     * @return mixed object|bool
     */
    public function create($data = '') {

        //save new user
        $file = new $this->files;

        //validate
        if (!is_array($data)) {
            return false;
        }

        //data
        $file->file_group_creatorid = auth()->id();
        $file->file_group_name = $data['file_filename'];
        $file->fileresource_type = $data['fileresource_type'];
        $file->fileresource_id = $data['fileresource_id'];
        
        //save and return id
        if ($file->save()) {
            return $file->file_group_id;
        } else {
            Log::error("unable to create record - database error", ['process' => '[FileGroupRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed int|bool
     */
    public function update($id) {

        //get the record
        if (!$file = $this->filegroups->find($id)) {
            return false;
        }

        //save
        if ($file->save()) {
            return $file->file_group_id;
        } else {
            Log::error("unable to update record - database error", ['process' => '[FileGroupRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }


}