<div class="row">

 
    <!--COMMENTS-->
    
    
    <!--LEADS-->
     <?php if(config('visibility.modules.leads')): ?>
        <?php echo $__env->make('pages.home.team.widgets.third-row.leads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <!--PROJECTS-->
     <?php if(config('visibility.modules.projects') && auth()->user()->role_id!=3 ): ?>
    <?php echo $__env->make('pages.home.team.widgets.third-row.projects', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    
    <!--CAD-->
    <?php if(config('visibility.modules.cad')): ?>
        <?php echo $__env->make('pages.home.team.widgets.third-row.cad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php if(auth()->user()->role_id==13): ?> 
        <?php echo $__env->make('pages.home.team.widgets.second-row.events', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?> 
 
    <!--tasks-->
    <?php if(config('visibility.modules.tasks')): ?>
        <?php echo $__env->make('pages.home.team.widgets.third-row.tasks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
     <!--Leave-->
        <?php echo $__env->make('pages.home.team.widgets.third-row.leaves', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <!--Tickets-->
    <?php if(config('visibility.modules.tickets') && auth()->user()->role_id!=3): ?>
        <?php echo $__env->make('pages.home.team.widgets.third-row.tickets', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/home/team/widgets/third-row/wrapper.blade.php ENDPATH**/ ?>