<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php if(session('message')): ?>
            <?php echo e(__('Services orders')); ?>: <?php echo e(session('message')); ?>

            <?php else: ?>
            <?php echo e(__('Services orders')); ?>

            <?php endif; ?>
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto select-none">
                    <div
                        class="bg-mejor-color border-8 m-4 p-6 dark:bg-mejor-color-dark dark:border-gray-700 w-lg rounded-lg shadow-lg  flex flex-wrap gap-6">
                        <!-- Resolution Area -->
                        <div class="flex-1 min-w-[200px]">
                            <form action="<?php echo e(route('order.index')); ?>" method="GET">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'resolution_area','class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300','value' => __('Resolution Area')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'resolution_area','class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Resolution Area'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                <div class="relative">
                                    <select id="resolution_area" name="resolution_area"
                                        class="block py-3 pl-10 pr-3 w-full text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800"
                                        onchange="this.form.submit()">
                                        <option value="" class="text-gray-500 dark:text-gray-400" disabled
                                            selected>-- <?php echo e(__('Select an option')); ?> --</option>
                                        <?php $__currentLoopData = $resolution_areas->sortBy('area'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resolution_area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($resolution_area->id); ?>"
                                                <?php echo e(request('resolution_area') == $resolution_area->id ? 'selected' : ''); ?>>
                                                <?php echo e($resolution_area->area); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Type -->
                        <div class="flex-1 min-w-[200px]">
                            <form action="<?php echo e(route('order.index')); ?>" method="GET">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'type','class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300','value' => __('Type')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'type','class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Type'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                <div class="relative">
                                    <select id="type" name="type"
                                        class="block py-3 pl-10 pr-3 w-full text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800"
                                        onchange="this.form.submit()">
                                        <option value="" class="text-gray-500 dark:text-gray-400" disabled
                                            selected>-- <?php echo e(__('Select an option')); ?> --</option>
                                        <?php $__currentLoopData = $types->sortBy('type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>"
                                                <?php echo e(request('type') == $type->id ? 'selected' : ''); ?>>
                                                <?php echo e($type->type); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Status -->
                        <div class="flex-1 min-w-[200px]">
                            <form action="<?php echo e(route('order.index')); ?>" method="GET">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'status','class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300','value' => __('Status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'status','class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                <div class="relative">
                                    <select id="status" name="status"
                                        class="block py-3 pl-10 pr-3 w-full text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800"
                                        onchange="this.form.submit()">
                                        <option class="text-gray-500 dark:text-gray-400" disabled selected
                                            value="">-- <?php echo e(__('Select an option')); ?> --</option>
                                        <?php $__currentLoopData = $statuses->sortBy('status'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status->id); ?>"
                                                <?php echo e(request('status') == $status->id ? 'selected' : ''); ?>>
                                                <?php echo e($status->status); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Filter Button -->
                        <div class="flex justify-end flex-none">
                            <a class="p-4 text-white transition-all duration-500 ease-in-out transform hover:scale-105"
                                href="<?php echo e(route('order.index')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <?php if (isset($component)) { $__componentOriginal5d619fa76042c03323e00a3c3cb71754 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d619fa76042c03323e00a3c3cb71754 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-order','data' => ['orders' => $orders]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-order'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['orders' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($orders)]); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d619fa76042c03323e00a3c3cb71754)): ?>
<?php $attributes = $__attributesOriginal5d619fa76042c03323e00a3c3cb71754; ?>
<?php unset($__attributesOriginal5d619fa76042c03323e00a3c3cb71754); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d619fa76042c03323e00a3c3cb71754)): ?>
<?php $component = $__componentOriginal5d619fa76042c03323e00a3c3cb71754; ?>
<?php unset($__componentOriginal5d619fa76042c03323e00a3c3cb71754); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo e($orders->onEachSide(5)->links('pagination::tailwind')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\franc\Desktop\ORDENRI\resources\views/order/index.blade.php ENDPATH**/ ?>