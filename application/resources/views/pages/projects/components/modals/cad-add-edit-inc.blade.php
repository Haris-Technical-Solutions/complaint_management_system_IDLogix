<div class="row" id="js-projects-modal-add-edit" data-section="{{ $page['section'] }}"
    data-project-progress="{{ $project['project_progress'] ?? 0 }}">
    <div class="col-lg-12">
        <!--meta data - creatd by-->
        @if(isset($page['section']) && $page['section'] == 'edit')
        <div class="modal-meta-data hidden">
            <small><strong>{{ cleanLang(__('lang.created_by')) }}:</strong>
                {{ $project->first_name ?? runtimeUnkownUser() }} |
                {{ runtimeDate($project->project_created) }}</small>
        </div>
        @endif

        <!--client<>-->
        @if(config('visibility.project_modal_client_fields'))
        <div class="client-selector">

            <!--existing client-->
            <div class="client-selector-container" id="client-existing-container">
                <div class="form-group row">
                    <label
                        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.client')) }}*</label>
                    <div class="col-sm-12 col-lg-9">
                        <!--select2 basic search-->
                        <select name="project_clientid" id="project_clientid"
                            class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                            data-ajax--url="{{ url('/') }}/feed/company_names"></select>
                        <!--select2 basic search-->
                        </select>
                    </div>
                </div>
            </div>

            <!--new client-->
            <div class="client-selector-container hidden" id="client-new-container">
                <div class="form-group row">
                    <label
                        class="col-sm-12 col-lg-4 text-left control-label col-form-label required">{{ cleanLang(__('lang.company_name')) }}*</label>
                    <div class="col-sm-12 col-lg-8">
                        <input type="text" class="form-control form-control-sm" id="client_company_name"
                            name="client_company_name">
                    </div>
                </div>

                <div class="form-group row">
                    <label
                        class="col-sm-12 col-lg-4 text-left control-label col-form-label required">{{ cleanLang(__('Sent to CAD')) }}</label>
                    <div class="col-sm-12 col-lg-8">
                        <input type="text" class="form-control form-control-sm" id="project_custom_field_15" name="project_custom_field_15"
                            
                            placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label
                        class="col-sm-12 col-lg-4 text-left control-label col-form-label required">{{ cleanLang(__('CAD Technician')) }}</label>
                    <div class="col-sm-12 col-lg-8">
                        <input type="text" class="form-control form-control-sm" id="last_name" name="last_name"
                            placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label
                        class="col-sm-12 col-lg-4 text-left control-label col-form-label required">{{ cleanLang(__('CAD Status')) }}</label>
                    <div class="col-sm-12 col-lg-8">
                        <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="">
                    </div>
                </div>
            </div>

            <!--option buttons-->
            <div class="client-selector-links">
                <a href="javascript:void(0)" class="client-type-selector" data-type="new"
                    data-target-container="client-new-container">@lang('lang.new_client')</a> |
                <a href="javascript:void(0)" class="client-type-selector active" data-type="existing"
                    data-target-container="client-existing-container">@lang('lang.existing_client')</a>
            </div>

            <!--client type indicator-->
            <input type="hidden" name="client-selection-type" id="client-selection-type" value="existing">
        </div>

        @endif
        <!--/#client-->

        <!--SELECT TEMPLATE-->
        @if($page['section'] == 'create')
        <div class="client-selectors">
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">@lang('lang.template')</label>
                <div class="col-sm-12 col-lg-9">
                    <select class="select2-basic form-control form-control-sm" id="project_template_selector"
                        data-url="{{ url('projects/prefill-project?action=reset') }}" data-allow-clear="true"
                        name="project_template_selector">
                        <option></option>
                        @foreach($templates as $template)
                        <option value="{{ $template->project_id }}"
                            data-url="{{ url('projects/prefill-project?id='.$template->project_id) }}"
                            data-id="{{ $template->project_id }}" data-title="{{ $template->project_title }}"
                            data-category="{{ $template->category_id }}"
                            data-billing-rate="{{ $template->project_billing_rate }}"
                            data-billing-type="{{ $template->project_billing_type }}"
                            data-billing-estimated-hours="{{ $template->project_billing_estimated_hours }}"
                            data-billing-estimated-cost="{{ $template->project_billing_costs_estimate }}"
                            data-assigned-manage-tasks="{{ $template->assignedperm_tasks_collaborate }}"
                            data-client-task-view="{{ $template->clientperm_tasks_view }}"
                            data-client-task-collaborate="{{ $template->clientperm_tasks_collaborate }}"
                            data-client-task-create="{{ $template->clientperm_tasks_create }}"
                            data-client-view-timesheets="{{ $template->clientperm_timesheets_view }}"
                            data-client-view-expenses="{{ $template->clientperm_expenses_view }}"
                            data-title="{{ $template->project_title }}">{{ $template->project_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif
        <!--/#SELECT TEMPLATE-->
        <!--Client-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.client')) }}*</label>
            <div class="col-sm-12 col-lg-9">

                 <input type="text" class="form-control form-control-sm" id="project_title" readonly
                    placeholder="" value="{{ $project->client->client_company_name ?? '' }}">
            </div>
        </div>
        <!--/#Client-->

        <!--TITLE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.project_title')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="project_title" readonly
                    placeholder="" value="{{ $project->project_title ?? '' }}">
            </div>
        </div>
         <!--Job Type-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.project').' '.__('lang.type')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" readonly id="project_custom_field_44" 
                    placeholder="" value="{{ $project->project_custom_field_44 ?? '' }}">
               
            </div>
        </div>
         <!--If Other selected-->
          @if( $project->project_custom_field_44 =='Other')
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Other Type')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="" readonly name=""
                    placeholder="" value="{{ $project->lead->lead_custom_field_5 ?? '' }}">
            </div>
        </div>
        @endif
        <!--/#Job Type-->
        <!--Unallocated Since DATE-->
        @if(($project->managers->count()==0 && $project->assigned->count()==0))
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Sent to CAD')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm " readonly name="project_custom_field_15"
                    autocomplete="off" value="{{ runtimeDatepickerDate($project->project_custom_field_15 ?? '') }}">
              
            </div>
        </div>
        @endif
        <!--/#Unallocated Since DATE-->
        <!--START DATE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('CAD Technician')) }}</label>
            <div class="col-sm-12 col-lg-9">
                   <select name="project_custom_field_53" id="project_custom_field_53"
                        class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                        multiple="multiple"
                         tabindex="-1" aria-hidden="true">
                        <!--users list-->
                        <option value=""></option>
                        @foreach(config('system.team_members')  as $user)
                        <option value="{{ $user->id }}" 
                    
                        
                         {{ runtimePreselectedInArray($user->id ?? '', json_decode($project->project_custom_field_53) ?? []) }}
                        >{{
                                            $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
            </div>
        </div>
        <!--/#START DATE-->
       
        <!--CAD Status-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('CAD Status')) }}</label>
            <div class="col-sm-12 col-lg-9">
                 <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ $cadstatuses->customfields_name }}"
                    name="{{ $cadstatuses->customfields_name }}" data-preselected="{{ $project->project_custom_field_41 ?? ''}}">
                   
                    {!! runtimeCustomFieldsJsonLists($cadstatuses->customfields_datapayload) !!}
                </select>
            </div>
        </div>
        
        <!--CAD Status-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('BIM Status')) }}</label>
            <div class="col-sm-12 col-lg-9">
                 <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ @$bim_statuses->customfields_name }}"
                    name="{{ @$bim_statuses->customfields_name }}" data-preselected="{{ $project->project_custom_field_71 ?? ''}}">
                    <option value="N/A" @if( $project->project_custom_field_71 =='N/A'){{'selected'}}@endif >N/A</option>
                    {!! runtimeCustomFieldsJsonLists(@$bim_statuses->customfields_datapayload) !!}
                </select>
            </div>
        </div>
        <!--/#assigned team members-->
        <!--Topo QA Approval-->
        @if($topo_qa_approval)
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Topo QA Approval')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ $topo_qa_approval->customfields_name }}"
                    name="{{ $topo_qa_approval->customfields_name }}" data-preselected="{{ $project->project_custom_field_72 ?? ''}}">
                    <option value="N/A" @if( $project->project_custom_field_72 =='N/A'){{'selected'}}@endif >N/A</option>
                    {!! runtimeCustomFieldsJsonLists($topo_qa_approval->customfields_datapayload) !!}
                </select>
            </div>
        </div>
        @endif
        <div class="form-group row hidden" id="topo_qa_approved_by">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Topo QA Approval By')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="project_custom_field_6"  name="project_custom_field_6"
                    placeholder="" value="{{ $project->project_custom_field_6 ?? '' }}">
                <input type="hidden"   name="cad_form"
                    value="yes">
            </div>
        </div>
         <!--Topo Report-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Topo Report')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ $topo_report->customfields_name }}"
                    name="{{ $topo_report->customfields_name }}" data-preselected="{{ $project->project_custom_field_48 ?? ''}}">
                    <option value="N/A" @if( $project->project_custom_field_48 =='N/A'){{'selected'}}@endif >N/A</option>
                    {!! runtimeCustomFieldsJsonLists($topo_report->customfields_datapayload) !!}
                </select>
            </div>
        </div>
         <!--Topo Survey-->
         @if($topo_survey)
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Topo Survey')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ $topo_survey->customfields_name }}"
                    name="{{ $topo_survey->customfields_name }}" data-preselected="{{ $project->project_custom_field_49 ?? ''}}">
                    <option value="N/A" @if( $project->project_custom_field_49 =='N/A'){{'selected'}}@endif >N/A</option>
                    {!! runtimeCustomFieldsJsonLists($topo_survey->customfields_datapayload) !!}
                </select>
            </div>
        </div>
        @endif
        <!--Utility QA Approval-->
        @if($utility_qa_approval)
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Utility QA Approval')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ $utility_qa_approval->customfields_name }}"
                    name="{{ $utility_qa_approval->customfields_name }}" data-preselected="{{ $project->project_custom_field_73 ?? ''}}">
                    <option value="N/A" @if( $project->project_custom_field_73 =='N/A'){{'selected'}}@endif >N/A</option>
                    {!! runtimeCustomFieldsJsonLists($utility_qa_approval->customfields_datapayload) !!}
                </select>
            </div>
        </div>
        @endif
        <div class="form-group row hidden" id="utility_qa_approved_by">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Utility QA Approval By')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="project_custom_field_7"  name="project_custom_field_7"
                    placeholder="" value="{{ $project->project_custom_field_7 ?? '' }}">
            </div>
        </div>
       <!--Utility Survey & Report-->
       @if($utiltiysurveyreport)
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Utility Survey & Report')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm select2-preselected a-custom-field" id="{{ $utiltiysurveyreport->customfields_name }}"
                    name="{{ $utiltiysurveyreport->customfields_name }}" data-preselected="{{ $project->project_custom_field_50 ?? ''}}">
                    <option value="N/A" @if( $project->project_custom_field_50 =='N/A'){{'selected'}}@endif >N/A</option>
                    {!! runtimeCustomFieldsJsonLists($utiltiysurveyreport->customfields_datapayload) !!}
                </select>
            </div>
        </div>
        @endif
        <div class="form-group row id="est_issue_date">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Sent to CAD Date')) }}</label>
            <div class="col-sm-12 col-lg-9">
               <input type="text" class="form-control form-control-sm pickadate" id="pickert_project_custom_field_15" name="project_custom_field_15"
                    autocomplete="off" value="{{ runtimeDatepickerDate($project->project_custom_field_15 ??  '') }}" data-value="{{ runtimeDatepickerDate($project->project_custom_field_15 ?? '') }}">
                <input class="mysql-date" type="hidden" name="project_custom_field_15" id="project_custom_field_15"
                    value="{{ $project->project_custom_field_15 ?? '' }}">
            </div>
        </div>
        <div class="form-group row id="est_issue_date">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Estimated Issue Date')) }}</label>
            <div class="col-sm-12 col-lg-9">
            @php 
            $est_date = $project->project_custom_field_17=='0000-00-00 00:00:00' || $project->project_custom_field_17==null ?date('Y-m-d'): $project->project_custom_field_17;
            @endphp
               <input type="text" class="form-control form-control-sm pickadate" id="pickert_project_custom_field_17" name="project_custom_field_17"
                    autocomplete="off" value="{{ runtimeDatepickerDate($est_date) }}" data-value="{{ runtimeDatepickerDate($est_date ) }}">
                <input class="mysql-date" type="hidden" name="project_custom_field_17" id="project_custom_field_17"
                    value="{{$est_date}}">
            </div>
        </div>
        <!--#Client Note-->
        <!--lead details - toggle-->
        <div  class="form-group row">
            
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('Issued to Client')) }}</label>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-left">
                    <label>
                        <input type="checkbox" name="project_custom_field_33" id="issue_to_client"
                             @if(@$project->project_custom_field_33=='yes'){{'checked'}}@endif >
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row  @if(@$project->project_custom_field_33!='yes'){{'hidden'}}@endif" id="issue_to_client_date">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Issue Date')) }}</label>
            <div class="col-sm-12 col-lg-9">
               <input type="text" class="form-control form-control-sm pickadate" id="pickert_project_custom_field_16" name="project_custom_field_16"
                    autocomplete="off" value="{{ runtimeDatepickerDate($project->project_custom_field_16 ??  date('y-m-d')) }}" data-value="{{ runtimeDatepickerDate($project->project_custom_field_16 ?? '') }}">
                <input class="mysql-date" type="hidden" name="project_custom_field_16" id="project_custom_field_16"
                    value="{{ $project->project_custom_field_16 ??  date('y-m-d') }} " >
            </div>
        </div>
        <!--Query Raised-->
        
        <div  class="form-group row">
            
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('Query Raised')) }}</label>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-left">
                    <label>
                        <input type="checkbox" name="project_custom_field_34" id="show_is_query_raised"
                            @if(@$project->project_custom_field_34=='yes'){{'checked'}}@endif >
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row  @if(@$project->project_custom_field_34!='yes'){{'hidden'}}@endif" id="add_is_query_raised">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('Query')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <textarea type="text" class="form-control form-control-sm tinymce-textarea a-custom-field" rows="5"   name="project_custom_field_21"
                    placeholder="" value="{{ $project->project_custom_field_21 ?? '' }}"></textarea>
            </div>
        </div>
       
        <!--CUSTOMER FIELDS [expanded] (july 2021 - the div container is necessary for project templates)-->
        {{-- 
        @if(config('system.settings_customfields_display_projects') == 'expanded')
        @if(isset($page['section']) && $page['section'] == 'edit' && isset($project->managers) && ($project->managers->count()>0 || $project->assigned->count()>0))
        <div id="project-custom-fields-container">
            
            @include('misc.customfields')
        </div>
        @endif
        @endif
        --}}
        </div>
        
        <div >
            <!--notes-->
            <div class="row">
                <div class="col-12">
                    <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
                </div>
            </div>
        </div>

        <!--redirect to project-->
        @if(config('visibility.project_show_project_option'))
        <div class="form-group form-group-checkbox row">
            <div class="col-12 text-left p-t-5">
                <input type="checkbox" id="show_after_adding" name="show_after_adding"
                    class="filled-in chk-col-light-blue" checked="checked">
                <label for="show_after_adding">{{ cleanLang(__('lang.show_project_after_its_created')) }}</label>
            </div>
        </div>
        @endif
    </div>