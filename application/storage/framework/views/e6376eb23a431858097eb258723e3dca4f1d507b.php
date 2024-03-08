<div class="row">
    <div class="col-lg-12">

        <?php if(config('system.settings_tickets_edit_subject') == 'yes'): ?>
        <div class="form-group row">
            <label
                class="col-sm-12 text-left control-label col-form-label required"><?php echo e(cleanLang(__('lang.subject'))); ?>*</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="ticket_subject" name="ticket_subject"
                    value="<?php echo e($ticket->ticket_subject); ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php if(config('system.settings_tickets_edit_body') == 'yes'): ?>
        <div class="form-group row">
            <label
                class="col-sm-12 text-left control-label col-form-label required"><?php echo e(cleanLang(__('lang.message'))); ?>*</label>
            <div class="col-sm-12">
                <textarea id="ticket_message" name="ticket_message"
                    class="tinymce-textarea"><?php echo e($ticket->ticket_message ?? ''); ?></textarea>
            </div>
        </div>
        <?php endif; ?>

        <?php if(request('edit_type') == 'options' || request('edit_type') == 'all'): ?>
        <!--department-->
        <div class="form-group row">
            <label for="example-month-input"
                class="col-sm-12 col-lg-3 col-form-label text-left required"><?php echo e(cleanLang(__('lang.department'))); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control  form-control-sm" id="ticket_categoryid"
                    name="ticket_categoryid">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->category_id); ?>"
                        <?php echo e(runtimePreselected($ticket->ticket_categoryid ?? '', $category->category_id)); ?>>
                        <?php echo e($category->category_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!--project-->
        <div class="form-group row">
            <label for="example-month-input"
                class="col-sm-12 col-lg-3 col-form-label text-left required"><?php echo e(cleanLang(__('lang.project'))); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control  form-control-sm" id="ticket_projectid"
                    name="ticket_projectid">
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($project->project_id); ?>"
                        <?php echo e(runtimePreselected($ticket->ticket_projectid ?? '', $project->project_id)); ?>>
                        <?php echo e($project->project_title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!--status-->
        <div class="form-group row">
            <label for="example-month-input"
                class="col-sm-12 col-lg-3 col-form-label text-left required"><?php echo e(cleanLang(__('lang.status'))); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control  form-control-sm" id="ticket_status" name="ticket_status">
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status->ticketstatus_id); ?>" <?php echo e(runtimePreselected($ticket->ticket_status ?? '', $status->ticketstatus_id)); ?>><?php echo e(runtimeLang($status->ticketstatus_title)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!--priority-->
        <div class="form-group row">
            <label for="example-month-input"
                class="col-sm-12 col-lg-3 col-form-label text-left required"><?php echo e(cleanLang(__('lang.priority'))); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control  form-control-sm" id="ticket_priority" name="ticket_priority">
                    <?php $__currentLoopData = config('settings.ticket_priority'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(runtimePreselected($ticket->ticket_priority ?? '', $key)); ?>><?php echo e(runtimeLang($key)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <?php endif; ?>

        <!--CUSTOMER FIELDS [collapsed]-->
        <?php if(config('system.settings_customfields_display_tickets') == 'toggled'): ?>
        <div class="spacer row">
            <div class="col-sm-12 col-lg-8">
                <span class="title"><?php echo e(cleanLang(__('lang.more_information'))); ?></span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="add_ticket_option_other" id="add_ticket_option_other"
                            class="js-switch-toggle-hidden-content" data-target="tickets_custom_fields_collaped">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <div id="tickets_custom_fields_collaped" class="hidden">
            <div id="project-custom-fields-container">
                <?php echo $__env->make('misc.customfields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <?php else: ?>
        <?php echo $__env->make('misc.customfields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>




        <!--type-->
        <input type="hidden" name="edit_type" value="<?php echo e(request('edit_type')); ?>">
        <input type="hidden" name="edit_source" value="<?php echo e(request('edit_source')); ?>">


        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* <?php echo e(cleanLang(__('lang.required'))); ?></strong></small></div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/tickets/components/modals/add-edit-inc.blade.php ENDPATH**/ ?>