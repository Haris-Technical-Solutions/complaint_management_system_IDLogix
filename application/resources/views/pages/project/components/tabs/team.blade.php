<div class="row project-details" id="project-team-container">
     <!--assigned team members<>-->
           {{-- @if(config('visibility.project_modal_assign_fields')) --}}
        <div class="col-sm-12 col-lg-9">
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label ">Quote Responsibility</label>
                <div class="col-sm-12 col-lg-9">
                   @foreach($project->lead->assigned as $user)
                    @php  $assigned[] = $user->full_name; @endphp
                    @endforeach
                    <input type="text" class="form-control form-control-sm" id="responsibility" readonly 
                            placeholder="" value="{{isset($assigned)?implode (", ", $assigned):''}}">
                </div>
            </div>
        </div>
        <!--CLient SM -->
        <div class="col-sm-12 col-lg-9">
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('Site Manager')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <select name="project_custom_field_52" id="project_custom_field_52"
                        class="form-control form-control-sm select2-basic select2-hidden-accessible"
                         tabindex="-1" aria-hidden="true">
                        <!--users list-->
                        <option value=""></option>
                        @foreach(@$contacts as $user)
                        <option value="{{ $user->id }}"   {{ $user->id==$project->project_custom_field_52?'selected':''  }}>{{
                                            $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
                </div>
            </div>
        </div>    
         <!--CLient PM -->
        <div class="col-sm-12 col-lg-9">
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('Project Manager')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <select name="project_custom_field_51" id="project_custom_field_51"
                        class="form-control form-control-sm select2-basic select2-hidden-accessible"
                         tabindex="-1" aria-hidden="true">
                        <!--users list-->
                        <option value=""></option>
                        @foreach(@$contacts as $user)
                        <option value="{{ $user->id }}"   {{ $user->id==$project->project_custom_field_51?'selected':''  }}>{{
                                            $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
                </div>
            </div>
        </div>
                 <!--project manager<>-->
    {{--         @if(config('visibility.project_modal_assign_fields'))--}}
     <div class="col-sm-12 col-lg-9">
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('Job Owner')) }}
                    <a class="align-middle font-14 toggle-collapse" href="#project_manager_info" role="button"><i
                            class="ti-info-alt text-themecontrast"></i></a></label>
                <div class="col-sm-12 col-lg-9">
                    <select name="manager" id="manager" class="select2-basic form-control form-control-sm"
                        data-allow-clear="true">
                        <!--array of assigned-->
                        @if(isset($page['section']) && $page['section'] == 'edit' && isset($project->managers))
                        @foreach($project->managers as $user)
                        @php $manager[] = $user->id; @endphp
                        @endforeach
                        @endif
                        <!--/#array of assigned-->
                        <!--users list-->
                        @foreach(config('system.team_members') as $user)
                        <option></option>
                        <option value="{{ $user->id }}"
                            {{ runtimePreselectedInArray($user->id ?? '', $manager ?? []) }}>{{
                                    $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
                </div>
            </div>
            </div>
         {{--      @endif--}}
        <div class="col-sm-12 col-lg-9">
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label ">{{ cleanLang(__('lang.team')) }}*</label>
                <div class="col-sm-12 col-lg-9">
                   
                    @if(config('system.settings_projects_permissions_basis') == 'category_based')
                    <div class="alert alert-info">@lang('lang.projects_assigned_auto')</div>
                    @else
                    <select name="assigned" id="assigned"
                        class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                        multiple="multiple" tabindex="-1" aria-hidden="true" >
                        <!--array of assigned-->
                        @if(isset($page['section']) && $page['section'] == 'edit' && isset($project->assigned))
                        @foreach($project->assigned as $user)
                        @php $assigned[] = $user->id; @endphp
                        @endforeach
                        @endif
                        <!--/#array of assigned-->
                        <!--users list-->
                        @foreach(config('system.team_members') as $user)
                        <option value="{{ $user->id }}"
                            {{ runtimePreselectedInArray($user->id ?? '', $assigned ?? []) }}>{{
                            $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
                    @endif
                </div>
            </div>
        </div>
      {{--      @endif --}}
            <!--/#assigned team members-->

   
   
        
        
</div>
 <hr>
        </hr>
        @if(auth()->user()->is_client==false && config('visibility.edit_project_button'))
          <!--button: subit & cancel-->
        <div id="project-description-submit" class="p-t-20  text-right">
            <button type="button" class="btn waves-effect waves-light btn-default"
                id="project-description-button-cancel">{{ cleanLang(__('lang.cancel')) }}</button>
            @if($project->project_categoryid==1)
           <button class="btn waves-effect waves-light  btn-danger  js-dynamic-url js-ajax-ux-request" data-toggle="tab"
                    id="tabs-menu-details" data-loading-class="loading-tabs"
                    data-loading-target="embed-content-container"
                    data-type="form"
                    data-ajax-type="put"
                    data-form-id="project-team-container"
                    data-dynamic-url="{{ _url('/projects') }}/{{ $project->project_id }}/details"
                    data-url="{{ _url('/projects') }}/{{ $project->project_id }}/assigned?ref=update&movetoworklog=0"
                    href="#projects_ajaxtab" role="tab">{{'Update'}}</button>
            @endif
            <button class="btn waves-effect waves-light  btn-danger  js-dynamic-url js-ajax-ux-request" data-toggle="tab"
                    id="tabs-menu-details" data-loading-class="loading-tabs"
                    data-loading-target="embed-content-container"
                    data-type="form"
                    data-ajax-type="put"
                    data-form-id="project-team-container"
                    data-dynamic-url="{{ _url('/projects') }}/{{ $project->project_id }}/details"
                    data-url="{{ _url('/projects') }}/{{ $project->project_id }}/assigned?ref=update&movetoworklog={{$project->project_categoryid==1?'1':'0'}}"
                    href="#projects_ajaxtab" role="tab">@if(@$project->assigned->count()==0 || @$project->project_categoryid==1) Move to Worklog @else {{'Update'}} @endif </button>
            
        </div>
        @endif
      