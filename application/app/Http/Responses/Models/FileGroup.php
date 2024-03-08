<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;


class FileGroup extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $primaryKey = 'file_group_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['file_group_id'];
    const CREATED_AT = 'file_group_created';
    const UPDATED_AT = 'file_group_updated';

    /**
     * relatioship business rules:
     *   - clients, project etc can have many comments
     *   - the assigned can be belong to just one of the above
     *   - files table columns named as [fileresource_type fileresource_id]
     */
    public function files() {
        return $this->hasMany('App\Models\File','file_group_id','file_group_id');
    }

    /**
     * relatioship business rules:
     *         - the Creator (user) can have many Files
     *         - the File belongs to one Creator (user)
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'file_creatorid', 'id');
    }

}
