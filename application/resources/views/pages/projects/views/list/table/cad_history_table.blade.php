<div class="count-{{ @count($projects) }}" id="projects-view-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive list-table-wrapper floating-scroller">
                @if (@count($projects) > 0)
                <table id="projects-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"   style=" overflow-x: auto;"
                    data-page-size="10">
                    <thead>
                        <tr>
                          
                            <th class="projects_col_id hidden">
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_id"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_id&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('lang.id')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>
                            <th class="projects_col_project">
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_title"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_title&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('lang.lead_title')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>
                             <th class="projects_col_project">
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_custom_field_44"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_title&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('Job Type')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>
                            
                            <th class="projects_col_client">
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_client"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_client&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('lang.client')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>

                            <th class="projects_col_project_custom_field_15">
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_custom_field_15"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_custom_field_15&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('Sent to CAD')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>
                            
                             <th class="projects_col_custom_field_18 ">
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_custom_field_18"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_custom_field_53&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('CAD Complete')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>
                              <th class="projects_col_project_custom_field_41"  >
                                <a class="js-ajax-ux-request js-list-sorting" id="sort_project_custom_field_41"
                                    href="javascript:void(0)"
                                    data-url="{{ urlResource('/projects?action=sort&orderby=project_custom_field_41&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('CAD Status')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                            </th>
                             <th class="projects_col_project_total_days"  >
                                <a class="" id="sort_project_total_days"
                                    href="javascript:void(0)"
                                        >{{ cleanLang(__('CAD Total Days')) }}</a>
                            </th>
                             <th class="projects_col_progress hidden"><a class="js-ajax-ux-request js-list-sorting"
                                    id="sort_project_project_custom_field_33" href="javascript:void(0)"
                                   data-url="{{ urlResource('/projects?action=sort&orderby=project_custom_field_33&sortorder=asc&filter_category='.request('filter_category')) }}">{{ cleanLang(__('Issued to Client')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                           
                            
                            <th class="projects_col_action hidden"><a
                                    href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                        </tr>
                    </thead>
                    <tbody id="projects-td-container">
                        <!--ajax content here-->
                        @include('pages.projects.views.list.table.cad_history_ajax')
                        <!--/ajax content here-->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="20">
                                <!--load more button-->
                                @include('misc.load-more-button')
                                <!--/load more button-->
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif @if (@count($projects) == 0)
                <!--nothing found-->
                @include('notifications.no-results-found')
                <!--nothing found-->
                @endif
            </div>
        </div>
    </div>
</div>