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
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/chartDashboard.js']); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <?php if (isset($component)) { $__componentOriginal521f4f95832e2adde3f13be3778c791b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal521f4f95832e2adde3f13be3778c791b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.charts.metrics-values','data' => ['counts' => $counts]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('charts.metrics-values'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['counts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($counts)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal521f4f95832e2adde3f13be3778c791b)): ?>
<?php $attributes = $__attributesOriginal521f4f95832e2adde3f13be3778c791b; ?>
<?php unset($__attributesOriginal521f4f95832e2adde3f13be3778c791b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal521f4f95832e2adde3f13be3778c791b)): ?>
<?php $component = $__componentOriginal521f4f95832e2adde3f13be3778c791b; ?>
<?php unset($__componentOriginal521f4f95832e2adde3f13be3778c791b); ?>
<?php endif; ?>
                    </div>
                    <h1 class="text-3xl my-2 font-bold mt-4"><?php echo e(__('Closed Orders')); ?></h1>
                    <label for="dayRange-1" class="text-gray-700  dark:text-gray-300">Selecciona el rango de
                        días:</label>
                    <select id="dayRange-1"
                        class="text-gray-700 w-full dark:text-gray-300 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-300 dark:bg-gray-700">
                        <option value="30">Últimos 30 días</option>
                        <option value="15">Últimos 15 días</option>
                        <option value="7">Últimos 7 días</option>
                    </select>

                    <canvas class="shadow-lg p-4 rounded-md border border-gray-300" id="myChart" width="400"
                        height="200" data-url="/api/metrics"></canvas>
                    <h1 class="text-3xl my-2 font-bold mt-4"><?php echo e(__('Created orders')); ?></h1>
                    <label for="dayRange-2" class="text-gray-700 justify-start dark:text-gray-300">Selecciona el
                        rango de
                        días:</label>
                    <select id="dayRange-2"
                        class="text-gray-700 w-full dark:text-gray-300 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-300 dark:bg-gray-700 transition duration-150 ease-in-out"
                        style="appearance: none; -moz-appearance: none; -webkit-appearance: none;">
                        <option value="30">Últimos 30 días</option>
                        <option value="15">Últimos 15 días</option>
                        <option value="7">Últimos 7 días</option>
                    </select>
                    <canvas id="myChart2" class="shadow-lg p-4 rounded-md border border-gray-300" width="400"
                        height="200" data-url="/api/metrics"></canvas>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\Users\franc\Desktop\ORDENRI\resources\views/dashboard.blade.php ENDPATH**/ ?>