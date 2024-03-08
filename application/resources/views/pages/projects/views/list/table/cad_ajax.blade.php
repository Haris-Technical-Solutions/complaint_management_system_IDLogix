@foreach($projects as $project)
@if(@$category != $project->project_categoryid)
@php $category = $project->project_categoryid; @endphp
<tr>
    <td colspan="11" data-rowid="{{$category}}" class="row_hd" id="tr_{{$category}}"> <i id="tri_{{$category}}" class="ti-minus"></i> {{@$project->category->category_name}}</td>
</tr>
@endif

<tr id="project_{{ $project->project_id }}" class="tr_{{$category}}">
   
    <td class="projects_col_id hidden">
        <a href="{{ _url('/projects/'.$project->project_id) }}/cad-info">{{ $project->project_id }}</label></a>
        
    </td>
    <td class="projects_col_project">
        <a href="{{ _url('/projects/'.$project->project_id) }}/cad-info">{{ str_limit($project->project_title ??'---', 20) }}<a/>
    </td>
     {{-- @if(config('visibility.projects_col_client')) --}}
    <td class="projects_col_client">
        <a
            href="/clients/{{ $project->project_clientid }}">{{ str_limit($project->client_company_name ??'---', 12) }}</a>
    </td>
    {{--    @endif --}}
     <td class="projects_col_project_custom_field_15 ">
        {{runtimeDate($project->project_custom_field_15) }}
    </td>
    <td class="projects_col_project_custom_field_53 ">
        {{ ($project->cad_technician->first_name??'') }}
        @php $technicians = json_decode($project->project_custom_field_53) @endphp
         @if($technicians !=null && count($technicians) > 0)
            @foreach($technicians as $user_id)
            @php $user = \App\Models\User::find($user_id); @endphp
            <img src="{{ $user->avatar }}" data-toggle="tooltip" title="{{ $user->first_name.' '.$user->last_name }}" data-placement="top"
                alt="{{ $user->first_name.' '.$user->last_name }}" class="img-circle avatar-xsmall">
            @endforeach
        @endif
        
        
    </td>
    <td class="projects_col_project_custom_field_41">
    <select id="table-lead-statuses" name="project_custom_field_41" style="width:160px;" class="  form-control form-control-sm {{ runtimeCadStatusColors($project->project_custom_field_41, 'label') }}" style=" color: #FFF;">
                <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Not Started', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Not Started" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;"
                    value="Not Started" {{ runtimePreselected('Not Started', $project->project_custom_field_41) }}>{{ cleanLang(__('lang.not_started')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Survey Data Received', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Survey Data Received" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Survey Data Received" {{ runtimePreselected('Survey Data Received', $project->project_custom_field_41) }}>{{ cleanLang(__('Survey Data Received')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Incomplete or missing data', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Incomplete or missing data" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Incomplete or missing data" {{ runtimePreselected('Incomplete or missing data', $project->project_custom_field_41) }}>{{ cleanLang(__('Incomplete or missing data')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Data Complete & Approved', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Data Complete & Approved" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Data Complete & Approved" {{ runtimePreselected('Data Complete & Approved', $project->project_custom_field_41) }}>{{ cleanLang(__('Data Complete & Approved')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Query Raised', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Query Raised" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Query Raised" {{ runtimePreselected('Query Raised', $project->project_custom_field_41) }}>{{ cleanLang(__('Query Raised')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Query Resolved', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Query Resolved" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Query Resolved" {{ runtimePreselected('Query Resolved', $project->project_custom_field_41) }}>{{ cleanLang(__('Query Resolved')) }}</option>
                    
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Drawing In Progress', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Drawing In Progress" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Drawing In Progress" {{ runtimePreselected('Drawing In Progress', $project->project_custom_field_41) }}>{{ cleanLang(__('Drawing In Progress')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Drawings Complete', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Drawings Complete" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Drawings Complete" {{ runtimePreselected('Drawings Complete', $project->project_custom_field_41) }}>{{ cleanLang(__('Drawings Complete')) }}</option>
                   
                   <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('In for Approval', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="In for Approval" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="In for Approval" {{ runtimePreselected('In for Approval', $project->project_custom_field_41) }}>{{ cleanLang(__('In for Approval')) }}</option>
                    
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Drawings Not Approved', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Drawings Not Approved" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Drawings Not Approved" {{ runtimePreselected('Drawings Not Approved', $project->project_custom_field_41) }}>{{ cleanLang(__('Drawings Not Approved')) }}</option>
                    
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('Drawings Approved', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="Drawings Approved" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="Drawings Approved" {{ runtimePreselected('Drawings Approved', $project->project_custom_field_41) }}>{{ cleanLang(__('Drawings Approved')) }}</option>
                   
                    <option style="font-size:13pt;" class="lead_list_status card-leads-update-status-link  label {{ runtimeCadStatusColors('CAD Complete', 'label') }}" data-button-text="card-task-status-text"
                    data-progress-bar='hidden' data-url="{{ urlResource('/projects/'.$project->project_id.'/change-cad-status?source=ext&action=sort') }}"
                    data-type="form" data-data_project_cad_status="CAD Complete" data-form-id="--set-self--"
                    data-ajax-type="post" style="margin-left:3px;width:98%;" value="CAD Complete" {{ runtimePreselected('CAD Complete', $project->project_custom_field_41) }}>{{ cleanLang(__('CAD Complete')) }}</option>
           
            </select>
    
    </td>
    <td class="projects_col_project_custom_field_71">{{ $project->project_custom_field_71 }}</td>
    <td class="projects_col_project_custom_field_72">{{ $project->project_custom_field_72 }}</td>
    <td class="projects_col_project_custom_field_73">{{ $project->project_custom_field_73 }}</td>
    <td class="projects_col_project_custom_field_16">{{ runtimeDate($project->project_custom_field_16) }}</td>
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