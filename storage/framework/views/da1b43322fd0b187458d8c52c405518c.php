<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="top-0 left-0 right-0 opacity-0 animate-fade-in z-10">
                <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <!-- Page Heading -->
                <?php if(isset($header)): ?>
                    <header class="bg-white  dark:bg-gray-800 shadow">
                        <div class="max-w-7xl  mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <?php echo e($header); ?>

                        </div>
                    </header>
                <?php endif; ?>
            </div>

            <!-- Page Content -->
            <main>
                <?php echo e($slot); ?>

            </main>

        </div>
        <?php if (isset($component)) { $__componentOriginal8894a2e2bc4abafd0afb132e7732b653 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8894a2e2bc4abafd0afb132e7732b653 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer-app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer-app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8894a2e2bc4abafd0afb132e7732b653)): ?>
<?php $attributes = $__attributesOriginal8894a2e2bc4abafd0afb132e7732b653; ?>
<?php unset($__attributesOriginal8894a2e2bc4abafd0afb132e7732b653); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8894a2e2bc4abafd0afb132e7732b653)): ?>
<?php $component = $__componentOriginal8894a2e2bc4abafd0afb132e7732b653; ?>
<?php unset($__componentOriginal8894a2e2bc4abafd0afb132e7732b653); ?>
<?php endif; ?>
    </body>

</html>
<?php /**PATH C:\Users\franc\Desktop\ORDENRI\resources\views/layouts/app.blade.php ENDPATH**/ ?>