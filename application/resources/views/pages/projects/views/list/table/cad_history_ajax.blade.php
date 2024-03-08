@foreach($projects as $project)
@if(@$category != $project->project_categoryid)
@php $category = $project->project_categoryid; @endphp
<tr>
    <td colspan="11" data-rowid="{{$category}}" class="row_hd" id="tr_{{$category}}"> <i id="tri_{{$category}}" class="ti-minus"></i> {{@$project->category->category_name}}</td>
</tr>
@endif

<tr id="project_{{ $project->project_id }}" class="tr_{{$category}}">
    @if(config('visibility.projects_col_checkboxes'))
    <td class="projects_col_checkbox checkitem" id="projects_col_checkbox_{{ $project->project_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-projects-{{ $project->project_id }}"
                name="ids[{{ $project->project_id }}]"
                class="listcheckbox listcheckbox-projects filled-in chk-col-light-blue"
                data-actions-container-class="projects-checkbox-actions-container">
            <label for="listcheckbox-projects-{{ $project->project_id }}"></label>
        </span>
    </td>
    @endif
    <td class="projects_col_id hidden">
        <a href="{{ _url('/projects/'.$project->project_id) }}/cad-info">{{ $project->project_id }}</label></a>
        
    </td>
    <td class="projects_col_project">
        <a href="{{ _url('/projects/'.$project->project_id) }}/cad-info">{{ str_limit($project->project_title ??'---', 20) }}<a/>
    </td>
    <td class="projects_col_project">
        {{ str_limit($project->project_custom_field_44 ??'---', 20) }} <a/>
    </td>
   
    <td class="projects_col_client">
        <a
            href="/clients/{{ $project->project_clientid }}">{{ str_limit($project->client_company_name ??'---', 12) }}</a>
    </td>
     <td class="projects_col_project_custom_field_15 ">
        {{runtimeDate($project->project_custom_field_15) }}
    </td>
    <td class="projects_col_project_custom_field_18 ">
        {{ runtimeDate($project->project_custom_field_18??'') }}
    </td>
    <td class="projects_col_project_custom_field_41">{{ $project->project_custom_field_41 }}</td>
    
    <td class="projects_col_project_total_days ">
        {{ $project->project_custom_field_18 ? runtimeDateDiffDays($project->project_custom_field_18 , $project->project_custom_field_15):'N/A' }}
    </td>
    <td class="projects_col_project_custom_field_33 hidden">
        {{ ($project->project_custom_field_33??'') }}
    </td>
   
    <td class="projects_col_action actions_column hidden">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
           {{--
            @if(config('visibility.action_buttons_delete'))
            <!--[delete]-->
            @if($project->permission_delete_project)
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ _url('/projects/'.$project->project_id) }}">
                <i class="sl-icon-trash"></i>
            </button>
            @else
            <!--optionally show disabled button?-->
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                    class="sl-icon-trash"></i></span>
            @endif
            @endif
            --}}
            <!--[edit]-->
             <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/projects/'.$project->project_id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_project')) }}"
                data-action-url="{{ urlResource('/projects/'.$project->project_id) }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                <i class="sl-icon-note"></i>
            </button>
            @if(config('visibility.action_buttons_edit'))
           {{-- @if($project->permission_edit_project)
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/projects/'.$project->project_id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_project')) }}"
                data-action-url="{{ urlResource('/projects/'.$project->project_id) }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                <i class="sl-icon-note"></i>
            </button>
            @else
            <!--optionally show disabled button?-->
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                    class="sl-icon-note"></i></span>
            @endif
            --}}
            @if(auth()->user()->role->role_assign_projects == 'yes')
            <button type="button" title="{{ cleanLang(__('lang.assigned_users')) }}"
                class="btn btn-outline-warning btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form data-toggle-action-tooltip"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/projects/'.$project->project_id.'/assigned') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.assigned_users')) }}"
                data-action-url="{{ urlResource('/projects/'.$project->project_id.'/assigned') }}" data-action-method="PUT"
                data-modal-size="modal-sm"
                data-action-ajax-class="ajax-request"
                data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                <i class="sl-icon-people"></i>
            </button>
            @endif
            @endif
            <!--view-->
            <a href="{{ _url('/projects/'.$project->project_id) }}" title="{{ cleanLang(__('lang.view')) }}"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
        <!--more button (team)-->
        @if(config('visibility.action_buttons_edit'))
        <span class="list-table-action dropdown font-size-inherit">
            <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                title="{{ cleanLang(__('lang.more')) }}"
                class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                <i class="ti-more"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="listTableAction">
                @include('pages.projects.views.common.dropdown-menu-team')
            </div>
        </span>
        @endif
    </td>
</tr>
@endforeach
<!--each row-->