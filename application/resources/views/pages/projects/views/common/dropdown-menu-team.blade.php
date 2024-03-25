<!--change category-->
@if($project->permission_edit_project)
<a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form" href="javascript:void(0)"
    data-toggle="modal" data-target="#actionsModal" data-modal-title="{{ cleanLang(__('lang.change_category')) }}"
    data-url="{{ url('/projects/change-category') }}"
    data-action-url="{{ urlResource('/projects/change-category?id='.$project->project_id.'&filter_category='.request('filter_category')) }}"
    data-loading-target="actionsModalBody" data-action-method="POST">
    {{ cleanLang(__('lang.change_category')) }}</a>
<!--change status-->
<a class="hidden dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form" href="javascript:void(0)"
    data-toggle="modal" data-target="#actionsModal" data-modal-title="{{ cleanLang(__('lang.change_status')) }}"
    data-url="{{ urlResource('/projects/'.$project->project_id.'/change-status') }}"
    data-action-url="{{ urlResource('/projects/'.$project->project_id.'/change-status?filter_category='.request('filter_category')) }}"
    data-loading-target="actionsModalBody" data-action-method="POST">
    {{ cleanLang(__('lang.change_status')) }}</a>
 <!--change cover image-->
 @if(config('visibility.edit_project_cover_image'))
<a class=" dropdown-item js-ajax-ux-request edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
    href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
    data-modal-title="{{ cleanLang(__('lang.change_cover_image')) }}"
    data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cover-image') }}"
    data-action-url="{{ urlResource('/projects/'.$project->project_id.'/change-cover-image') }}"
    data-loading-target="commonModalBody" data-action-method="POST">
    {{ cleanLang(__('lang.change_cover_image')) }}</a>
@endif
<!--update progress-->
<a class="hidden dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form" href="javascript:void(0)"
    data-toggle="modal" data-target="#actionsModal" data-modal-title="{{ cleanLang(__('lang.update_progress')) }}"
    data-url="{{ url('/projects/'.$project->project_id.'/progress?ref=list') }}"
    data-action-url="{{ url('/projects/'.$project->project_id.'/progress?ref=list&filter_category='.request('filter_category')) }}"
    data-loading-target="actionsModalBody" data-action-method="POST">
    {{ cleanLang(__('lang.update_progress')) }}</a>

<!--stop all timers-->
<a class="hidden dropdown-item confirm-action-danger" data-confirm-title="{{ cleanLang(__('lang.stop_all_timers')) }}"
    data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
    data-url="{{ urlResource('/projects/'.$project->project_id.'/stop-all-timers') }}">
    {{ cleanLang(__('lang.stop_all_timers')) }}
</a>

<!--clone project-->
@if(auth()->user()->role->role_projects > 1)
<a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form edit-add-modal-button"
    href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
    data-modal-title="{{ cleanLang(__('lang.clone_project')) }}"
    data-url="{{ url('/projects/'.$project->project_id.'/clone') }}"
    data-action-url="{{ url('/projects/'.$project->project_id.'/clone?filter_category='.request('filter_category')) }}"
    data-loading-target="actionsModalBody" data-action-method="POST">
    {{ cleanLang(__('lang.clone_project')) }}</a>
@endif

<!--archive-->
@if($project->project_active_state == 'active' && runtimeArchivingOptions())
<a class="dropdown-item confirm-action-info" data-confirm-title="{{ cleanLang(__('lang.archive_project')) }}"
    data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
    data-url="{{ urlResource('/projects/'.$project->project_id.'/archive') }}">
    {{ cleanLang(__('lang.archive')) }}
</a>
@endif

<!--activate-->
@if($project->project_active_state == 'archived' && runtimeArchivingOptions())
<a class="dropdown-item confirm-action-info" data-confirm-title="{{ cleanLang(__('lang.restore_project')) }}"
    data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
    data-url="{{ urlResource('/projects/'.$project->project_id.'/activate') }}">
    {{ cleanLang(__('lang.restore')) }}
</a>
@endif


<!--automation-->
<a href="javascript:void(0)" class="hidden dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
    data-toggle="modal" data-target="#commonModal"
    data-url="{{ urlResource('/projects/'.$project->project_id.'/edit-automation?ref=list') }}"
    data-loading-target="commonModalBody" data-modal-title="@lang('lang.project_automation')"
    data-action-url="{{ urlResource('/projects/'.$project->project_id.'/edit-automation?ref=list') }}"
    data-action-method="POST" data-action-ajax-loading-target="commonModalBody">@lang('lang.automation')
</a>

@else
<span class="small">--- no options avaiable</span>
@endif