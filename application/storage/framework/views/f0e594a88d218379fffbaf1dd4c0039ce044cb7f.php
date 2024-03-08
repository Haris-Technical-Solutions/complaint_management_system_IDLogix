<div class="card count-<?php echo e(@count($leads ?? [])); ?>" id="leads-view-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            <?php if(@count($leads ?? []) > 0): ?>
            <table id="leads-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                <thead>
                    <tr>
                        <?php if(config('visibility.leads_col_checkboxes')): ?>
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-leads" name="listcheckbox-leads"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="leads-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-leads">
                                <label for="listcheckbox-leads"></label>
                            </span>
                        </th>
                        <?php endif; ?>
                        <th class="leads_col_title">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_lead_title" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/leads?action=sort&orderby=lead_title&sortorder=asc')); ?>"><?php echo e(cleanLang(__('lang.title'))); ?><span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                            </a>
                        </th>
                        <th class="leads_col_contact">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_lead_firstname"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/leads?action=sort&orderby=lead_firstname&sortorder=asc')); ?>"><?php echo e(cleanLang(__('lang.contact'))); ?><span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                            </a>
                        </th>
                        <th class="leads_col_date">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_lead_created"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/leads?action=sort&orderby=lead_created&sortorder=asc')); ?>"><?php echo e(cleanLang(__('lang.date'))); ?><span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                            </a>
                        </th>
                        <th class="leads_col_company">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_lead_company_name"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/leads?action=sort&orderby=category_name&sortorder=asc')); ?>"><?php echo e(cleanLang(__('lang.category'))); ?><span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                            </a>
                        </th>

                        <th class="leads_col_assigned"><?php echo e(cleanLang(__('lang.assigned'))); ?></th>
                        <th class="leads_col_stage">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_status" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/leads?action=sort&orderby=status&sortorder=asc')); ?>"><?php echo e(cleanLang(__('lang.status'))); ?><span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                            </a>
                        </th>
                        <th class="leads_col_value">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_lead_value" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/leads?action=sort&orderby=lead_value&sortorder=asc')); ?>"><?php echo e(cleanLang(__('lang.value'))); ?><span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                            </a>
                        </th>
                        <th class="leads_col_action"><a href="javascript:void(0)"><?php echo e(cleanLang(__('lang.action'))); ?></a></th>
                    </tr>
                </thead>
                <tbody id="leads-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('pages.leads.components.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?> <?php if(@count($leads ?? []) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/leads/components/table/table.blade.php ENDPATH**/ ?>