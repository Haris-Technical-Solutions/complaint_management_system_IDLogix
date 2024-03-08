<div class="card count-{{ @count($leaves) }}" id="leaves-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($leaves) > 0)
            <table id="leave-foo-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                <thead>
                    <tr>
                        @if(config('visibility.leaves_col_checkboxes'))
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-leaves" name="listcheckbox-leaves"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="leaves-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-leaves">
                                <label for="listcheckbox-leaves"></label>
                            </span>
                        </th>
                        @endif
                        <th class="leaves_col_added">{{ cleanLang(__('lang.requested_by')) }}</th>
                        <th class="leaves_col_title ">{{ cleanLang(__('lang.type')) }}</th>
                        <th class="leaves_col_tags">{{ cleanLang(__('lang.start_date')) }}</th>
                        <th class="leaves_col_date">{{ cleanLang(__('lang.end_date')) }}</th>
                        <th class="leaves_col_date">{{ cleanLang(__('lang.status')) }}</th>
                        <th class="leaves_col_action"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    </tr>
                </thead>
                <tbody id="leaves-td-container">
                    <!--ajax content here-->
                    @include('pages.leaves.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($leaves) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>