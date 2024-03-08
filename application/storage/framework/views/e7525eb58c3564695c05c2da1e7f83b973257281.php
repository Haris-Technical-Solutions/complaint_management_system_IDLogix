<!-- action buttons -->
<?php echo $__env->make('pages.tickets.components.misc.list-page-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- action buttons -->

<!--stats panel-->
<?php if(auth()->user()->is_team): ?>
<div id="tickets-stats-wrapper" class="stats-wrapper card-embed-fix">
<?php if(@count($tickets ?? []) > 0): ?> <?php echo $__env->make('misc.list-pages-stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?>
</div>
<?php endif; ?>
<!--stats panel-->

<!--tickets table-->
<div class="card-embed-fix">
<?php echo $__env->make('pages.tickets.components.table.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!--tickets table--><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/tickets/tabswrapper.blade.php ENDPATH**/ ?>