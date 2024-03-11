<div class="col-lg-4  col-md-12">
    <div class="card project-box">
        <div class="card-body project-inbox">
             <h5 class="card-title"><?php echo e(cleanLang(__('lang.tasks'))); ?></h5> 
            <?php $tasks = $payload['my_tasks'] ; ?>
            <div class="table-responsive  list-table-wrapper dashboard-projects" id="dashboard-client-tasks">
                <table class="table table-hover">
                    <thead style="position:sticky; top:0; ">
                        <tr >
                            <th><?php echo e(cleanLang(__('lang.task'))); ?></th>
                            <th><?php echo e(cleanLang(__('lang.project'))); ?></th>
                            <th><?php echo e(cleanLang(__('lang.start_date'))); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           
                            <td class="txt-oflo"><a
                                    href="/tasks/<?php echo e($task->task_id); ?>"><?php echo e(str_limit($task->task_title ??'---', 20)); ?></a>
                            </td>
                            <td><?php echo e(str_limit($task->project_title ??'---', 20)); ?></td>
                            <td><?php echo e(runtimeDate($task->task_date_start)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/home/team/widgets/third-row/tasks.blade.php ENDPATH**/ ?>