<div class="count-{{ @count($projects) }}" id="projects-view-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive list-table-wrapper floating-scroller">
                @if (@count($projects) > 0)
                <table id="projects-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"   style=" overflow-x: auto;"
                    data-page-size="10">
                    <thead>
                        <tr>
                            <th class="">
                                Job Type
                            </th>
                            <th class="">
                                Total Jobs
                            </th>
                           <th class="">
                               Avg Days
                            </th>
                        </tr>
                    </thead>
                    <tbody id="projects-td-container">
                        <!--ajax content here-->
                        @include('pages.projects.views.list.table.cad_states_ajax')
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