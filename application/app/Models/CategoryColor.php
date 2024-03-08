<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryColor extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'color_list';
    protected $primaryKey = 'color_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['color_id'];
    const CREATED_AT = 'color_created';
    const UPDATED_AT = 'color_updated';

    

}
