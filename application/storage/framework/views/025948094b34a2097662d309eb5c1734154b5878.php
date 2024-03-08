<!-- Column -->
<div class="card" id="project_details" data-progress="<?php echo e($project->project_progress); ?>">

    <!--cover image-->
    <?php if(config('visibility.project_cover_image')): ?>
    <div class="project-cover-image-wrapper js-hover-actions <?php echo e(config('visibility.project_cover_image_current')); ?>">
        <img id="project-cover-image"
            src="<?php echo e(clean(getCoverImage($project->project_cover_directory ?? '', $project->project_cover_filename ?? '', 'image'))); ?>"
            alt="image">

        <!-- cover image buttons-->
        <?php if(config('visibility.project_cover_image')): ?>
        <div class="js-hover-actions-target edit_project_cover_wrapper hidden" id="edit_project_cover_wrapper">
            <!--edit cover-->
            <button type="button"
                class="data-toggle-tooltip btn waves-effect btn-sm waves-light btn-rounded btn-info js-ajax-ux-request edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                title=" <?php echo app('translator')->get('lang.change_cover_image'); ?>" data-toggle="modal" data-target="#commonModal"
                data-modal-title="<?php echo e(cleanLang(__('lang.change_cover_image'))); ?>"
                data-url="<?php echo e(urlResource('/projects/'.$project->project_id.'/change-cover-image?view=page')); ?>"
                data-action-url="<?php echo e(urlResource('/projects/'.$project->project_id.'/change-cover-image')); ?>"
                data-loading-target="commonModalBody" data-action-method="POST">
                <i class="sl-icon-note"></i>
            </button>
            <!--remove cover-->
            <button type="button" data-toggle="tooltip" title="<?php echo app('translator')->get('lang.remove_cover_image'); ?>"
                class="btn waves-effect btn-sm waves-light btn-rounded btn-danger data-toggle-action-tooltip confirm-action-danger"
                title="<?php echo e(cleanLang(__('lang.edit'))); ?>" data-confirm-title="<?php echo app('translator')->get('lang.remove_cover_image'); ?>"
                data-confirm-text="<?php echo app('translator')->get('lang.are_you_sure'); ?>" data-ajax-type="POST" 
                data-url="<?php echo e(urlResource('/projects/'.$project->project_id.'/remove-cover-image')); ?>">
                <i class="sl-icon-trash"></i>
            </button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
 
    <div class="card-body p-t-10 p-b-10" id="project_progress_container">
        <!--project progress-->
        
        <!--project progress-->
        <!--this item is archived notice-->
        <?php if($project->project_active_state == 'archived' && runtimeArchivingOptions()): ?>
        <div
            class="alert alert-warning p-t-7 p-b-7 m-t-10 m-b--20<?php echo e(runtimeActivateOrAchive('archived-notice', $project->project_active_state)); ?>">
            <i class="mdi mdi-archive"></i> <?php echo app('translator')->get('lang.this_project_is_archived'); ?>
        </div>
        <?php endif; ?>
    </div>
    <!--hidden-->
    
    <div class="card-body p-t-0 p-b-0">
        <!--[client details]-->
        <?php if(auth()->user()->is_team): ?>
        <div class="p-b-20">
            <h6><a href="/clients/<?php echo e($project->client_id); ?>"><?php echo e($project->client_company_name); ?></a></h6>
            <div>
                <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span data-toggle="tooltip" title="<?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?>"><img
                        src="<?php echo e(getUsersAvatar($contact->avatar_directory, $contact->avatar_filename)); ?>" alt="user"
                        class="img-circle avatar-xsmall"></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!--assigned-->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel-label p-b-3"><?php echo e(cleanLang(__('lang.assigned'))); ?></div>
                <div>
                    <?php $__currentLoopData = $project->assigned; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span data-toggle="tooltip" title="<?php echo e($team->first_name); ?> <?php echo e($team->last_name); ?>"><img
                            src="<?php echo e(getUsersAvatar($team->avatar_directory, $team->avatar_filename)); ?>" alt="user"
                            class="img-circle avatar-xsmall"></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($project->assigned()->count() == 0): ?>
                    ---
                    <?php endif; ?>
                </div>
            </div>

            <!--project manager-->
            <div class="col-sm-6">
                <?php if(auth()->user()->is_team): ?>
                <div class="panel-label p-b-3"><?php echo e(cleanLang(__('lang.project_manager'))); ?></div>
                <div>
                    <?php $__currentLoopData = $project->managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span data-toggle="tooltip" title="<?php echo e($team->first_name); ?> <?php echo e($team->last_name); ?>"><img
                            src="<?php echo e(getUsersAvatar($team->avatar_directory, $team->avatar_filename)); ?>" alt="user"
                            class="img-circle avatar-xsmall"></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($project->managers()->count() == 0): ?>
                    ---
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>



        </div>

        <!--project tags-->
        <?php if(auth()->user()->is_team): ?>
        <div class="row m-t-20">
            <div class="col-12">
                <div class="panel-label p-b-3"><?php echo e(cleanLang(__('lang.tags'))); ?></div>
                <div class="l-h-24">
                    <?php $__currentLoopData = $project->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="label label-rounded label-default tag p-t-3 p-b-3"><?php echo e($tag->tag_title); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!--dates-->
    
    <!--billing details-->
    

    


    <?php if(config('visibility.project_show_custom_fields')): ?>
    <!--CUSTOMER FIELDS-->
    <div class="m-t-10 m-b-10">
        <hr>
    </div>
    <div class="card-body p-t-0 p-b-0">
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($field->customfields_show_project_page == 'yes'): ?>
        <div class="x-each-field m-b-18">
            <div class="panel-label p-b-3"><?php echo e($field->customfields_title); ?>

            </div>
            <div class="x-content"><?php echo clean(customFieldValue($field->customfields_name, $project,
                $field->customfields_datatype)); ?></div>
        </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(config('app.application_demo_mode')): ?>
        <!--DEMO INFO-->
        <div class="alert alert-info">
            <h5 class="text-info"><i class="sl-icon-info"></i> Demo Info</h5>
            These are custom fields. You can change them or <a
                href="<?php echo e(url('app/settings/customfields/projects')); ?>">create your own.</a>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    <div class="d-none last-line">
        <hr>
    </div>
</div>
<!-- Column --><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/project/components/misc/details.blade.php ENDPATH**/ ?>