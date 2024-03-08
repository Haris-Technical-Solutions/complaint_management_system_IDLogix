<div class="row">
    <div class="col-lg-12">
        @csrf
        <!--Team Member-->
       
        @php $u = auth()->user() @endphp
     
        @if( $u->role->role_id == 3 ||$u->role->role_id == 12 || $u->role->role_id == 13)
            <input type="hidden" name="leave_requester_userid" id="leave_requester_userid" value={{auth()->id()}} />
        @else
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.requested_by')) }}*</label>
            <div class="col-sm-12">
                <select name="leave_requester_userid" @if(@$leave->leave_id!='') {{'disabled'}} @endif  id="leave_requester_userid" class="select2-basic form-control form-control-sm"
                        data-allow-clear="true">
                        <!--users list-->
                        @foreach(config('system.team_members') as $user)
                        <option></option>
                        <option value="{{ $user->id }}"
                            {{ runtimePreselected($user->id ?? '',  $leave->leave_requester_userid ?? '' ) }}>{{
                                    $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
            </div>
        </div>
        @endif
        <!--title-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">Request {{ cleanLang(__('lang.type')) }}*</label>
            <div class="col-sm-12">
                <select name="leave_type" id="leave_type" class="select2-basic form-control form-control-sm"
                        data-allow-clear="true">
                        <!--users list-->
                        <option value="Holiday" {{ runtimePreselected('Holiday',  $leave->leave_type ?? request('leave_type') ) }}>Holiday</option>
                        <option value="Sickness" {{ runtimePreselected('Sickness',  $leave->leave_type ?? request('leave_type') ) }}>Sickness</option>
                        <option value="Overtime" {{ runtimePreselected('Overtime',  $leave->leave_type ?? request('leave_type') ) }}>Overtime</option>                        
                        <!--/#users list-->
                    </select>
            </div>
        </div>
        <!--title-->
        <div class="form-group row hidden">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.title')) }}*</label>
            <div class="col-sm-12">
                <input type="text" @if(@$leave->leave_id!='') {{'disabled'}} @endif  class="form-control form-control-sm" autocomplete="off" id="leave_title"
                    name="leave_title" value="{{ $leave->leave_title ?? 'Employee Request' }}">
            </div>
        </div>

        <!--description-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label ">{{ cleanLang(__('lang.leave_reason')) }}</label>
            <div class="col-sm-12">
                <textarea id="leave_description" @if(@$leave->leave_id!='') {{'disabled'}} @endif  name="leave_reason"
                    class="tinymce-textarea hidden">{{ $leave->leave_reason ?? '' }}</textarea>
            </div>
        </div>

        <!--Start Date-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.start_date')) }}*</label>
            <div class="col-sm-12">
               <input type="text" @if(@$leave->leave_id!='') {{'disabled'}} @endif  class="form-control form-control-sm pickadate" id="pickert_leave_start_date" name="leave_start_date"
                    autocomplete="off" value="{{ runtimeDatepickerDate($leave->leave_start_date ??  '') }}" data-value="{{ runtimeDatepickerDate($leave->leave_start_date ?? '') }}">
                <input class="mysql-date" type="hidden" name="leave_start_date" id="leave_start_date"
                    value="{{ $leave->leave_start_date ?? '' }}">

            </div>
        </div>
        <!--End Date-->
        <div class="form-group row  {{request('leave_type')=='Overtime' || @$leave->leave_type=='Overtime' ? 'hidden':''}} " id="lb_end_date">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.end_date')) }}*</label>
            <div class="col-sm-12">
                <input type="text" @if(@$leave->leave_id!='') {{'disabled'}} @endif  class="form-control form-control-sm pickadate" id="pickert_leave_end_date" name="leave_end_date"
                    autocomplete="off" value="{{ runtimeDatepickerDate($leave->leave_end_date ??  '') }}" data-value="{{ runtimeDatepickerDate($leave->leave_end_date ?? '') }}">
                <input class="mysql-date" type="hidden" name="leave_end_date" id="leave_end_date"
                    value="{{ $leave->leave_end_date ?? '' }}">

            </div>
        </div>
         <div class="form-group row">
            @if(request('leave_type')=='Overtime' || @$leave->leave_type=='Overtime')
            <label id="lbl_day_to_taken" class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('Overtime Hours')) }}*</label>
            @else
            <label id="lbl_day_to_taken" class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('Days to be Taken')) }}*</label>
            @endif
            <div class="col-sm-12">
                <input type="number" @if(@$leave->leave_id!='') {{'disabled'}} @endif  class="form-control form-control-sm" autocomplete="off" id="day_to_taken"
                    name="day_to_taken" value="{{ $leave->day_to_taken ?? '' }}">
            </div>
        </div>
         <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.department')) }}*</label>
            <div class="col-sm-12">
                <select name="department" id="department" class="select2-basic form-control form-control-sm"
                        data-allow-clear="true">
                        <!--users list-->
                        <option value="Holiday" {{ runtimePreselected('Holiday',  $leave->department ?? '' ) }}>Office</option>
                        <option value="Topo Surveyor" {{ runtimePreselected('Topo Surveyor',  $leave->department ?? '' ) }}>Topo Surveyor</option>
                        <option value="Utilities Surveyor" {{ runtimePreselected('Utilities Surveyor',  $leave->department ?? '' ) }}>Utilities Surveyor</option>
                        <option value="CAD Team" {{ runtimePreselected('CAD Team',  $leave->department ?? '' ) }}>CAD Team</option>

                        <!--/#users list-->
                    </select>
            </div>
        </div>
        <!--Team Member-->
       
         @if( $u->role->role_id == 3 ||$u->role->role_id == 12  || $u->role->role_id == 13)
            <input type="hidden" name="leave_status" id="leave_status" value="Pending" />
        @else
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.status')) }}*</label>
            <div class="col-sm-12">
                <select name="leave_status" id="leave_status" class="select2-basic form-control form-control-sm"
                        data-allow-clear="true">
                        <!--users list-->
                        <option value="Pending" {{ runtimePreselected('Pending',  $leave->leave_status ?? '' ) }}>Pending</option>
                        <option value="Partially Approved" {{ runtimePreselected('PartiallyApproved',  $leave->leave_status ?? '' ) }}>Partially Approved</option>
                        <option value="Approved" {{ runtimePreselected('Approved',  $leave->leave_status ?? '' ) }}>Approved</option>
                        <option value="Rejected" {{ runtimePreselected('Rejected',  $leave->leave_status ?? '' ) }}>Rejected</option>

                        <!--/#users list-->
                    </select>
            </div>
        </div>
        @endif
        <!--leaves-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>

      
    </div>
</div>
