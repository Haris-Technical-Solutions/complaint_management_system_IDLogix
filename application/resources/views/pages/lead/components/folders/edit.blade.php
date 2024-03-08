<!--folders edit view-->
<div class="folders-edit-view p-t-10" id="folders-edit-view">
    <input type="hidden" 
                name="fileresource_id" value="{{$fileresource_id}}">
    <input type="hidden" 
                name="fileresource_type" value="{{$fileresource_type}}">          
    <!--item-->
    @foreach($folders as $folder)
    <div class="form-group row" id="filefile_group_id_{{ $folder->file_group_id }}">
        <div class="col-12 each-folder">
            @if($folder->filefolder_default == 'yes')
            <input type="text" class="form-control form-control-sm" id="file_group_name"
                name="file_group_name[{{ $folder->file_group_id }}]" value="{{ $folder->file_group_name }}" disabled>
            <a href="javascript:void(0);" class="delete-button text-default"
                title="@lang('lang.system_default_folder_cannot_be_deleted')" data-toggle="tooltip">
                <i class="sl-icon-trash"></i>
            </a>
            @else
            <input type="text" class="form-control form-control-sm" id="file_group_name"
                name="file_group_name[{{ $folder->file_group_id }}]" value="{{ $folder->file_group_name }}">
            <a href="javascript:void(0);" class="delete-button text-danger confirm-action-danger"
                title="@lang('lang.delete')" data-confirm-title="@lang('lang.delete_folder')" data-confirm-text=""
                data-confirm-checkbox="yes" data-confirm-checkbox-label="@lang('lang.delete_all_files_in_folder')"
                data-confirm-checkbox-field-id="file_group_{{ $folder->file_group_id }}" 
                data-type="form"  data-form-id="--set-self--" data-ajax-type="post"
                data-fileresource_id="{{$folder->file_group_resource_id}}" data-fileresource_type="{{$folder->file_group_resource_type}}" 
                data-group_id="{{$folder->file_group_id }}" 
                data-url="{{ urlResource('/filegroups/deletefolder?filegroup_id='.$folder->file_group_id.'&fileresource_type='.$folder->file_group_resource_type.'&fileresource_id='.$folder->file_group_resource_id) }}">
                <i class="sl-icon-trash"></i>
            </a>
            <input type="hidden" class="confirm_hidden_fields" name="file_group_{{ $folder->file_group_id }}"
                id="file_group_{{ $folder->file_group_id }}">
            @endif
        </div>
    </div>
    @endforeach


    <!--form buttons-->
    <div class="text-right">
        <button type="submit" id="folders-add-button-submit"
            class="btn btn-default btn-xs waves-effect text-left ajax-request"
            data-url="{{ urlResource('/filegroups/showlist') }}" data-type="form" data-form-id="folders-edit-view"
            data-ajax-type="post" data-button-loading-annimation="yes"
            data-on-start-submit-button="disable">@lang('lang.cancel')</button>

        <button type="submit" id="folders-edit-button-submit"
            class="btn btn-danger btn-xs waves-effect text-left ajax-request"
            data-url="{{ urlResource('/filegroups/updatefolders') }}" data-type="form" data-form-id="folders-edit-view"
            data-ajax-type="post" data-loading-target="folders-body"
            data-on-start-submit-button="disable">@lang('lang.submit')</button>
    </div>

</div>