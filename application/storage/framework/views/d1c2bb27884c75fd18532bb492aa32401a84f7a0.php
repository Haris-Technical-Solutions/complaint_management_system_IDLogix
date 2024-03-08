<div class="row">
    <div class="col-lg-12">
        <!-- Nav tabs -->
        <ul data-modular-id="project_tabs_menu" class="nav nav-tabs profile-tab project-top-nav list-pages-crumbs"
            role="tablist">
            
            <!--[tasks]-->
            <?php if(config('settings.project_permissions_view_tasks')): ?>
            <li class="nav-item">
                <a class="nav-link tabs-menu-item   js-dynamic-url js-ajax-ux-request" data-toggle="tab"
                    id="tabs-menu-tasks" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                    data-dynamic-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/tasks"
                    data-url="<?php echo e(url('/tasks')); ?>?source=ext&taskresource_type=project&taskresource_id=<?php echo e($project->project_id); ?>"
                    href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.tasks'))); ?></a>
            </li>
            <?php endif; ?>
            <!--overview-->
            <li class="nav-item">
                <a class="nav-link tabs-menu-item" href="/projects/<?php echo e($project->project_id); ?>" role="tab"
                    id="tabs-menu-overview"><?php echo e(cleanLang(__('lang.overview'))); ?></a>
            </li>
            <!--details-->
            <li class="nav-item">
                <a class="nav-link tabs-menu-item   js-dynamic-url js-ajax-ux-request" data-toggle="tab"
                    id="tabs-menu-details" data-loading-class="loading-tabs"
                    data-loading-target="embed-content-container"
                    data-dynamic-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/details"
                    data-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/project-details"
                    href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.details'))); ?></a>
            </li>
            <!--[milestones]-->
            

            <!--[files]-->
            <?php if(config('settings.project_permissions_view_files')): ?>
            <li class="nav-item">
                <a class="nav-link  tabs-menu-item   js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_files'] ?? ''); ?>"
                    data-toggle="tab" id="tabs-menu-files" data-loading-class="loading-tabs"
                    data-loading-target="embed-content-container"
                    data-dynamic-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/files"
                    data-url="<?php echo e(url('/files')); ?>?source=ext&fileresource_type=project&fileresource_id=<?php echo e($project->project_id); ?>&filter_folderid=<?php echo e($project->default_folder_id); ?>"
                    href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.files'))); ?></a>
            </li>
            <?php endif; ?>
            <!--[comments]-->
            <?php if(config('settings.project_permissions_view_comments')): ?>
            <li class="nav-item ">
                <a class="nav-link  tabs-menu-item   js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_discussions'] ?? ''); ?>"
                    id="tabs-menu-comments" data-toggle="tab" data-loading-class="loading-tabs"
                    data-loading-target="embed-content-container"
                    data-dynamic-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/comments"
                    data-url="<?php echo e(url('/comments')); ?>?source=ext&commentresource_type=project&commentresource_id=<?php echo e($project->project_id); ?>"
                    href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.comments'))); ?></a>
            </li>
            <?php endif; ?>
            <!--billing-->
            

            <!--[MODULES] - dynamic menu-->
            <?php echo config('module_menus.project_tabs_menu'); ?>


            <!--[MODULES]-->
            <li data-modular-id="project_tabs_menu_more" class="nav-item dropdown <?php echo e($page['tabmenu_more'] ?? ''); ?>">
                <a class="nav-link dropdown-toggle  tabs-menu-item" data-loading-class="loading-tabs"
                    data-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true"
                    id="tabs-menu-billing" aria-expanded="false">
                    <span class="hidden-xs-down"><?php echo e(cleanLang(__('lang.more'))); ?></span>
                </a>
                <div class="dropdown-menu" x-placement="bottom-start" id="fx-topnav-dropdown">

                    <!--[MODULES-->


                    <!--tickets-->
                    <?php if(config('settings.project_permissions_view_tickets')): ?>
                    <a class="dropdown-item tabs-menu-item   js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_tickets'] ?? ''); ?>"
                        id="tabs-menu-tickets" data-toggle="tab" data-loading-class="loading-tabs"
                        data-loading-target="embed-content-container"
                        data-dynamic-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/tickets"
                        data-url="<?php echo e(url('/tickets')); ?>?source=ext&ticketresource_type=project&ticketresource_id=<?php echo e($project->project_id); ?>"
                        href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.tickets'))); ?></a>
                    <?php endif; ?>

                    <!--notes-->
                    <?php if(config('settings.project_permissions_view_notes')): ?>
                    <a class="dropdown-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_notes'] ?? ''); ?>"
                        id="tabs-menu-notes" data-toggle="tab" data-loading-class="loading-tabs"
                        data-loading-target="embed-content-container"
                        data-dynamic-url="<?php echo e(_url('/projects')); ?>/<?php echo e($project->project_id); ?>/notes"
                        data-url="<?php echo e(url('/notes')); ?>?source=ext&noteresource_type=project&noteresource_id=<?php echo e($project->project_id); ?>"
                        href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.notes'))); ?></a>
                    <?php endif; ?>

                </div>
            </li>
        </ul>
        <!-- Tab panes -->

        <?php echo $__env->make('pages.files.components.actions.checkbox-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/project/components/misc/topnav.blade.php ENDPATH**/ ?>