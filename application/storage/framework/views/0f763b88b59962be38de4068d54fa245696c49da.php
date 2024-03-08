<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" id="js-trigger-nav-team"> <!--[fix] keep id as "js-trigger-nav-team"-->
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul data-modular-id="main_menu_client" id="sidebarnav">

                <!--home-->
                <li data-modular-id="main_menu_client_home"
                    class="sidenav-menu-item <?php echo e($page['mainmenu_home'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                    title="<?php echo e(cleanLang(__('lang.home'))); ?>">
                    <a class="waves-effect waves-dark" href="/home" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.dashboard'))); ?>

                        </span>
                    </a>
                </li>
                <!--home-->


                <!--projects[home]-->
                <?php if(config('visibility.modules.projects')): ?>
                <li data-modular-id="main_menu_client_projects"
                    class="sidenav-menu-item <?php echo e($page['mainmenu_projects'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                    title="<?php echo e(cleanLang(__('lang.projects'))); ?>">
                    <a class="waves-effect waves-dark" href="<?php echo e(_url('/projects')); ?>" aria-expanded="false"
                        target="_self">
                        <i class="ti-folder"></i>
                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.projects'))); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!--projects-->

                <?php if(auth()->user()->is_client_owner): ?>
                
                <?php endif; ?>

                <!--proposals-->
                


                
                <!--contracts-->
                


                <!--[MODULES] - dynamic menu-->
                <?php echo config('module_menus.main_menu_client'); ?>


                <!--users-->
                <?php if(auth()->user()->is_client_owner): ?>
                <li data-modular-id="main_menu_client_users"
                    class="sidenav-menu-item <?php echo e($page['mainmenu_contacts'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                    title="<?php echo e(cleanLang(__('lang.users'))); ?>">
                    <a class="waves-effect waves-dark" href="/users" aria-expanded="false" target="_self">
                        <i class="sl-icon-people"></i>
                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.users'))); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!--users-->

                <!--tickets represents support on front side-->
                <?php if(config('visibility.modules.tickets')): ?>
                <li data-modular-id="main_menu_client_tickets"
                    class="sidenav-menu-item <?php echo e($page['mainmenu_tickets'] ?? ''); ?> menu-tooltip menu-with-tooltip"
                    title="<?php echo e(cleanLang(__('lang.support_tickets'))); ?>">
                    <a class="waves-effect waves-dark" href="/tickets" aria-expanded="false" target="_self">
                        <i class="ti-comments"></i>
                        <span class="hide-menu"><?php echo e(cleanLang(__('lang.support'))); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!--tickets-->

                <!--knowledgebase-->
                
                <!--knowledgebase-->

                <?php echo config('menus.main_menu_client'); ?>


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside><?php /**PATH C:\laragon\www\cms\application\resources\views/nav/leftmenu-client.blade.php ENDPATH**/ ?>