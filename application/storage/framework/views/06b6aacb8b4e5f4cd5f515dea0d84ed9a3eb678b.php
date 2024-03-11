<div class="col-lg-6  col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo e(cleanLang(__('lang.my_tasks'))); ?></h5>
            <?php $projects = $payload['my_projects'] ; ?>
            <div class="dashboard-projects" id="dashboard-client-projects">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><?php echo e(cleanLang(__('lang.title'))); ?></th>
                            <th><?php echo e(cleanLang(__('lang.project'))); ?></th>
                            <th><?php echo e(cleanLang(__('lang.priority'))); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php $__currentLoopData = $payload['my_tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($task->task_id); ?></td>
                            <td class="txt-oflo"><a href="/tasks/v/<?php echo e($task->task_id); ?>"><?php echo e(str_limit($task->task_title ??'---', 20)); ?></a>
                            </td>
                            <td><a href="/projects/<?php echo e($task->task_projectid); ?>/tasks"><?php echo e($task->project->project_title); ?></a></td>
                            <td><span class="text-success"><span
                                        class="label <?php echo e(runtimeTaskPriorityColors($task->task_priority, 'label')); ?>"><?php echo e(runtimeLang($task->task_priority)); ?></span></span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/home/team/widgets/second-row/tasks.blade.php ENDPATH**/ ?>