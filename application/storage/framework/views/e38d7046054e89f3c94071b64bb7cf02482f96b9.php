<div class="row">

    <!--EVENTS-->
    <?php echo $__env->make('pages.home.team.widgets.second-row.events', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--PROJECTS-->
   <?php echo $__env->make('pages.home.team.widgets.second-row.tasks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/home/team/widgets/second-row/wrapper.blade.php ENDPATH**/ ?>