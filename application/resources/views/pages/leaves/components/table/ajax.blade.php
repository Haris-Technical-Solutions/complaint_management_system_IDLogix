@foreach($leaves_withtypes as $type)
<tr id="leave_{{ $type['title'] }}" style="background:rgba(255,198,80,0.4);">
    <td colspan="6">
      <i id="tri_87" class="ti-minus"></i>  {{ $type['title'] }}
    </td>
</tr>
@foreach($type['leaves'] as $leave)
<!--each row-->
<tr id="leave_{{ $leave->leave_id }}">
    @if(config('visibility.leaves_col_checkboxes'))
    <td class="leaves_col_checkbox checkitem" id="leaves_col_checkbox_{{ $leave->leave_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-leaves-{{ $leave->leave_id }}" name="ids[{{ $leave->leave_id }}]"
                class="listcheckbox listcheckbox-leaves filled-in chk-col-light-blue"
                data-actions-container-class="leaves-checkbox-actions-container">
            <label for="listcheckbox-leaves-{{ $leave->leave_id }}"></label>
        </span>
    </td>
    @endif
    <td class="leaves_col_added">
        <img src="{{ getUsersAvatar($leave->avatar_directory, $leave->avatar_filename) }}" alt="user"
            class="img-circle avatar-xsmall">
        {{ $leave->first_name ?? runtimeUnkownUser() }} {{ $leave->last_name ?? '' }}
    </td>
    <td class="leaves_col_title ">
        <a 
             title="{{$leave->leave_reason}}"   
              class="data-toggle-action-tooltip edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/leaves/'.$leave->leave_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_leave')) }}"
                data-action-url="{{ urlResource('/leaves/'.$leave->leave_id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="leaves-td-container"
                style="cursor:pointer;"
             >
            {{ str_limit($leave->leave_title, 65) }}
        </a>
        {{-- <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="{{ url('/') }}/leaves/{{  $leave->leave_id }}" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title="" title="{{$leave->leave_reason}}">
            {{ str_limit($leave->leave_title, 65) }}
        </a> --}}
    </td>

    <td class="leaves_col_date {{ $page[ 'visibility_col_date'] ?? '' }} ">{{ runtimeDate($leave->leave_start_date) }}
    </td>

    <td class="leaves_col_date {{ $page[ 'visibility_col_date'] ?? '' }} ">{{ runtimeDate($leave->leave_end_date) }}
    </td>
    <td class="leaves_col_status  ">{{$leave->leave_status}}
    </td>
    <td class="leaves_col_action  actions_column {{ $page[ 'visibility_col_action'] ?? '' }} ">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            {{-- $leave->permission_edit_delete_leave && --}}
            @if( $leave->permission_edit_delete_leave && $leave->leave_status=='Pending')
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_leave')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE" data-url="{{ url( '/') }}/leaves/{{  $leave->leave_id }} ">
                <i class="sl-icon-trash"></i>
            </button>
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/leaves/'.$leave->leave_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_leave')) }}"
                data-action-url="{{ urlResource('/leaves/'.$leave->leave_id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="leaves-td-container">
                <i class="sl-icon-note"></i>
            </button>
            @else
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-trash"></i></span>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-note"></i></span>
            @endif
            <a href="javascript:void(0)" title="{{ cleanLang(__('lang.view')) }}"
                class="hidden data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm show-modal-button js-ajax-ux-request"
                data-toggle="modal" data-url="{{ url( '/') }}/leaves/{{  $leave->leave_id }} " data-target="#plainModal"
                data-loading-target="plainModalBody" data-modal-title="">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
@endforeach

<!--each row-->