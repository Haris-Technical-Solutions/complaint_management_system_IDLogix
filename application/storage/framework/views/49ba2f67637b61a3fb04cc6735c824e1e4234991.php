<div class="row">
    <div class="col-lg-12">

        <?php if(config('system.settings2_extras_dimensions_billing') == 'enabled'): ?>
        <div class="modal-selector">
            <!--item-->
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Product Type</label>
                <div class="col-sm-12 col-lg-9">
                    <select class="select2-basic form-control form-control-sm select2-preselected" id="item_type"
                        name="item_type" data-preselected="<?php echo e($item->item_type ?? ''); ?>">
                        <option value="standard">Standard Product</option>
                        <option value="dimensions">Dimensions Product</option>
                    </select>
                </div>
            </div>
        </div>
        <?php else: ?>
        <input type="hidden" name="item_type" value="standard">
        <?php endif; ?>

        <!--description-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label  required"><?php echo e(cleanLang(__('lang.description'))); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <textarea class="w-100" id="item_description" rows="5"
                    name="item_description"><?php echo e($item->item_description ?? ''); ?></textarea>
            </div>
        </div>


        <!--rate-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required"><?php echo e(cleanLang(__('lang.rate'))); ?>*</label>
            <div class="col-sm-12 col-lg-9 input-group input-group-sm">
                <span class="input-group-addon"><?php echo e(config('system.settings_system_currency_symbol')); ?></span>
                <input type="number" name="item_rate" id="item_rate" class="form-control form-control-sm"
                    value="<?php echo e($item->item_rate ?? ''); ?>">
            </div>
        </div>

        <?php if(config('system.settings2_extras_dimensions_billing') == 'enabled'): ?>
        <div id="items_dimensions_container" class="<?php echo e(runtimeVisibilityItemsType($item->item_type ?? '')); ?>">

            <!--item_dimensions_length-->
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Length</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="number" class="form-control form-control-sm" id="item_dimensions_length"
                        name="item_dimensions_length" value="<?php echo e($item->item_dimensions_length ?? ''); ?>">
                </div>
            </div>


            <!--item_dimensions_width-->
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Width</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="number" class="form-control form-control-sm" id="item_dimensions_width"
                        name="item_dimensions_width" value="<?php echo e($item->item_dimensions_width ?? ''); ?>">
                </div>
            </div>

        </div>
        <?php endif; ?>


        <!--units-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label  required"><?php echo e(cleanLang(__('lang.units'))); ?>*
                <span class="align-middle text-info font-16" data-toggle="tooltip"
                    title="<?php echo e(cleanLang(__('lang.units_examples'))); ?>" data-placement="top"><i
                        class="ti-info-alt"></i></span></label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="item_unit" name="item_unit"
                    value="<?php echo e($item->item_unit ?? ''); ?>">
            </div>
        </div>

        <!--category-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label  required"><?php echo e(cleanLang(__('lang.category'))); ?>*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="item_categoryid" name="item_categoryid">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->category_id); ?>"
                        <?php echo e(runtimePreselected($item->item_categoryid ?? '', $category->category_id)); ?>><?php echo e(runtimeLang($category->category_name)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!--item_tax_status-->
        <input type="hidden" name="item_tax_status" value="taxable">


        <!--item_notes_estimatation - toggle-->
        <div class="spacer row">
            <div class="col-sm-12 col-lg-8">
                <span class="title"><?php echo app('translator')->get('lang.estimation_notes'); ?></span> <span class="align-middle text-info font-16" data-toggle="tooltip" title="<?php echo app('translator')->get('lang.estimate_notes_info'); ?>"
                data-placement="top"><i class="ti-info-alt"></i></span>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="more_information" id="item_notes_estimatation_toggle"
                            class="js-switch-toggle-hidden-content" data-target="item_notes_estimatation_panel">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--item_notes_estimatation-->
        <div class="hidden p-t-10" id="item_notes_estimatation_panel">
            <div class="form-group row">
                <div class="col-sm-12">
                    <textarea class="form-control form-control-sm tinymce-textarea-plain" rows="5"
                        name="item_notes_estimatation"
                        id="item_notes_estimatation"><?php echo e($item->item_notes_estimatation ?? ''); ?></textarea>
                </div>
            </div>
        </div>




        <!--item_notes_production [not currently used]-->
        <div class="form-group row hidden">
            <label
                class="col-sm-12 text-left control-label col-form-label required"><?php echo app('translator')->get('lang.production_notes'); ?></label>
            <div class="col-sm-12 ">
                <textarea class="form-control form-control-sm tinymce-textarea-plain" rows="5"
                    name="item_notes_production"
                    id="item_notes_production"><?php echo e($item->item_notes_production ?? ''); ?></textarea>
            </div>
        </div>



        <!--pass source-->
        <input type="hidden" name="source" value="<?php echo e(request('source')); ?>">
        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* <?php echo e(cleanLang(__('lang.required'))); ?></strong></small></div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cms\application\resources\views/pages/items/components/modals/add-edit-inc.blade.php ENDPATH**/ ?>