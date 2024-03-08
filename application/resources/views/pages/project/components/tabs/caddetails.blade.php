<div class="row project-details" id="project-details-container">
    
        
    <div class="col-sm-12 tinymce-transparent">
        @include('pages.projects.components.modals.cad-add-edit-inc')

        
        @if(config('visibility.edit_project_button') || in_array(auth()->user()->role->role_id,array(12,13,4) ))
        <hr>
        </hr>
        <!--buttons: edit-->
        <div id="project-description-edit" class="p-t-20 text-right hidden">
            <button type="button" class="btn waves-effect waves-light btn-xs btn-info"
                id="project-description-button-edit">{{ cleanLang(__('lang.edit_description')) }}</button>
        </div>

        <!--button: subit & cancel-->
        <div id="project-description-submit" class="p-t-20  text-right">
            <button type="button" class="btn waves-effect waves-light btn-default"
                id="project-description-button-cancel">{{ cleanLang(__('lang.cancel')) }}</button>
            <button type="button" class="btn waves-effect waves-light  btn-danger" data-type="form"
                data-form-id="project-details-container" data-ajax-type="post"
                data-url="{{ url('projects/'.$project->project_id .'/cad-details?ref=list') }}"
                id="project-description-button-save">{{ cleanLang(__('lang.save')) }}</button>
            @if( $project->assigned->count()==0)
            <button class="hidden btn waves-effect waves-light  btn-danger  js-dynamic-url js-ajax-ux-request" data-toggle="tab"
                    id="project-detail-button-team-allocate" data-loading-class="loading-tabs"
                    data-loading-target="embed-content-container"
                    data-dynamic-url="{{ _url('/projects') }}/{{ $project->project_id }}/details"
                    data-url="{{ _url('/projects') }}/{{ $project->project_id }}/team"
                    href="#projects_ajaxtab" role="tab">Allocate {{ cleanLang(__('lang.team')) }}</button>
            @endif
        </div>
        @endif

    </div>
</div>