<div class="folder-panel col-md-12">

    <div class="folder-header clearfix">
        <h5><i class="ti-folder display-inline-block m-r-4"></i> @lang('lang.folders')</h5>
      {{--  @if(config('visibility.manage_file_folders')) --}}
        <div class="folder-actions">
            <!--<span class="dropdown cursor-pointer" data-toggle="dropdown" aria-haspopup="true"-->
            <!--    id="folder-actions-settings" aria-expanded="false">-->
            <!--    <i class="ti-more"></i>-->
            <!--</span>-->
            <span class=" cursor-pointer"  aria-haspopup="true"
                id="folder-actions-create" aria-expanded="false">
               <a class="js-ajax-ux-request" href="javascript:void(0);"  title="@lang('lang.create_a_folder')"
                    data-button-loading-annimation="no" data-url="{{ urlResource('/filegroups/create?fileresource_type=lead&fileresource_id='.$lead->lead_id) }}">
                    <i class="mdi mdi-plus-circle-outline"></i></a>
            </span>
            <span class=" cursor-pointer" aria-haspopup="true"
                id="folder-actions-edit" aria-expanded="false">
                <a class=" edit-add-modal-button js-ajax-ux-request reset-target-modal-form" title="@lang('lang.edit_folders')"
                    href="javascript:void(0)" data-url="{{ urlResource('/filegroups/edit?fileresource_type=lead&fileresource_id='.$lead->lead_id) }}"
                    data-button-loading-annimation="no">
                    <i class="ti-pencil"></i></a>
            </span>
            <!--<div class="dropdown-menu" aria-labelledby="folder-actions-settings">-->
                <!--create_a_folder-->
            <!--    <a class="dropdown-item js-ajax-ux-request" href="javascript:void(0);"-->
            <!--        data-button-loading-annimation="no" data-url="{{ urlResource('/filegroups/create') }}">-->
            <!--        <i class="mdi mdi-plus-circle-outline"></i> @lang('lang.create_a_folder')</a>-->
                <!--edit_folders-->
            <!--    <a class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"-->
            <!--        href="javascript:void(0)" data-url="{{ urlResource('/filegroups/edit') }}"-->
            <!--        data-button-loading-annimation="no">-->
            <!--        <i class="ti-pencil"></i> @lang('lang.edit_folders')</a>-->
            <!--</div>-->
           
        </div>
       {{-- @endif --}}
    </div>

    <div class="folders-body p-t-15" id="folders-body">
        <!--folders [list] view-->
        @include('pages.lead.components.folders.list')
    </div>

</div>