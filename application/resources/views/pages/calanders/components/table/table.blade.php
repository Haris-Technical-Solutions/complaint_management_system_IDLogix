<nav class="navbar">
              <button type="button" data-toggle="tooltip" title="{{ cleanLang(__('lang.show_archive_leads')) }}"
            id="pref_filter_show_archived_leads"
            class="hidden list-actions-button btn btn-page-actions waves-effect waves-dark js-ajax-ux-request {{ runtimeActive(auth()->user()->pref_filter_show_archived_leads) }}"
            data-url="{{ url('/leads/search?action=search&toggle=pref_filter_show_archived_leads') }}">
            <i class="ti-archive"></i>
            </button>
            <input type="hidden" id="defaultViewType" value="{{auth()->user()->default_calander_view}}">
            <!--leads kanban task sorting-->
            <div class="dropdown dropdown-trigger btn-group " id="">
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="list-actions-button btn waves-effect waves-dark dropdown-toggle">
                     <span class="button-text"></span>
                      <span
                        class="dropdown-icon toastui-calendar-icon toastui-calendar-ic-dropdown-arrow"
                      ></span></button>
                <div class="dropdown-menu dropdown-menu-right fx-kaban-sorting-dropdown" style="margin-right:-57px;">
                    <div class="dropdown-content">
                      <a  href="javascript:void(0);" data-url="{{ urlResource('/user/updatecalanderview') }}"
                        data-type="form"  data-data_viewName="month" data-form-id="--set-self--"data-ajax-type="post" class="js-ajax-ux-request dropdown-item" data-view-name="month">Monthly</a>
                      <a  data-data_viewName="week" href="javascript:void(0);" data-url="{{ urlResource('/user/updatecalanderview') }}"
                        data-type="form"  data-form-id="--set-self--"data-ajax-type="post" class="js-ajax-ux-request dropdown-item" data-view-name="week">Weekly</a>
                      <a href="javascript:void(0);" data-data_viewName="day" data-url="{{ urlResource('/user/updatecalanderview') }}"
                        data-type="form" data-form-id="--set-self--"data-ajax-type="post" class="js-ajax-ux-request dropdown-item" data-view-name="day">Daily</a>
                      <a href="javascript:void(0);" data-url="{{ urlResource('/user/updatecalanderview') }}"
                        data-type="form"  data-data_viewName="timeline" data-form-id="--set-self--"data-ajax-type="post" class="js-ajax-ux-request dropdown-item" data-view-name="timeline">Timeline</a>
                    </div>
                </div>
            </div>
               
                
                <button class="btn btn-danger today">Today</button>
                <button class="btn btn-rounded-x btn-secondary prev">
                  <img
                    alt="prev"
                    src="public/calander/examples/images/ic-arrow-line-left.png"
                    srcset="
                      public/calander/examples/images/ic-arrow-line-left@2x.png 2x,
                      public/calander/examples/images/ic-arrow-line-left@3x.png 3x
                    "
                  />
                </button>
                <button class="btn btn-rounded-x btn-secondary next">
                  <img
                    alt="prev"
                    src="public/calander/examples/images/ic-arrow-line-right.png"
                    srcset="
                      public/calander/examples/images/ic-arrow-line-right@2x.png 2x,
                      public/calander/examples/images/ic-arrow-line-right@3x.png 3x
                    "
                  />
                </button>
                <span class="navbar--range"></span>
                <!--<div class="navbar--range"></div>-->
                <div class="nav-checkbox " style="visibility:hidden">
                  <input class="checkbox-collapse" type="checkbox" id="collapse" value="collapse" />
                  <label for="collapse">Collapse duplicate events and disable the detail popup</label>
                </div>
          </nav>
<div id="tasks-view-wrapper" class="timeline_view hidden">
<div id="gantt_data" class="hidden">@json($data)</div>
<div id="child_tasks" class="hidden">@json($child_tasks)</div>
<div id="parent_tasks" class="hidden">@json($parent_tasks)</div>
<input type="hidden" id="cal_start" class="hidden" value="{{$cal_start_date}}"/>
<input type="hidden" id="cal_end" class="hidden" value="{{$cal_end_date}}"/>

<div id="gantt_parent_div"  class="zoom-in">
<div id="gantt_here" style='width:100%; height:700px;' class="zoom-out">asd</div>
</div>
</div>

<!--task modal-->
@include('pages.calanders.components.table.calendar')
<script>
    //  cTaskData = @json($child_tasks);
</script>