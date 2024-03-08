<!--bulk actions-->
<?php echo $__env->make('pages.leads.components.actions.checkbox-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!--main table view-->
<?php echo $__env->make('pages.leads.components.table.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\laragon\www\cms\application\resources\views/pages/leads/components/table/wrapper.blade.php ENDPATH**/ ?>