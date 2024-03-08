@foreach($filegroups as $file)
    <!--each row-->
        <div class="col-md-3" id="filegroup_{{ $file->file_group_id }}" style="">
            <a class="js-ajax-ux-request js-list-sorting" id="file_group_open"
                href="javascript:void(0)"
                data-loading-target="embed-content-container"                    
                data-url="{{ url('/files') }}?source=ext&fileresource_type=project&filegroup_id={{ $file->file_group_id }}&fileresource_id={{ $file->file_group_resource_id }}">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom:15px;" id="filegroups_col_file_{{ $file->file_group_id }}">
                    <img style="margin-right:15px;" src="https://geomap.imaginedesigns.co/storage/menu-icons/Jobs.svg" width="20px" height="20px">
                        {{$file->file_group_name}} asss
                    </div>
                </div>
            </a>
        </div>
    <!--each row-->
@endforeach
<div class="col-md-3" id="filegroup_{{ $file->file_group_id }}" style="">
            <a class="js-ajax-ux-request js-list-sorting" id="file_group_open"
                href="javascript:void(0)"
                data-loading-target="embed-content-container"                    
                data-url="{{ url('/files') }}?source=ext&fileresource_type=project&filegroup_id={{ $file->file_group_id }}&fileresource_id={{ $file->file_group_resource_id }}">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom:15px;" id="filegroups_col_file_{{ $file->file_group_id }}">
                    <!-- <i class="mdi mdi-plus-circle-multiple-outline text-danger font-28"></i> -->
                    <!-- <img style="margin-right:15px;" src="https://geomap.imaginedesigns.co/storage/menu-icons/Jobs.svg" width="20px" height="20px"> -->
                    Add New Folder
                    </div>
                   
                </div>
            </a>
        </div>