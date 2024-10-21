<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gray-800 min-h-screen flex items-center justify-center']); ?>
    <?php if (isset($component)) { $__componentOriginal41d51155e84d441a6a8cd32434074bb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41d51155e84d441a6a8cd32434074bb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.register-layout','data' => ['jobTitles' => $job_titles,'generalManagements' => $general_managements]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('register-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['job_titles' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job_titles),'general_managements' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($general_managements)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41d51155e84d441a6a8cd32434074bb9)): ?>
<?php $attributes = $__attributesOriginal41d51155e84d441a6a8cd32434074bb9; ?>
<?php unset($__attributesOriginal41d51155e84d441a6a8cd32434074bb9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41d51155e84d441a6a8cd32434074bb9)): ?>
<?php $component = $__componentOriginal41d51155e84d441a6a8cd32434074bb9; ?>
<?php unset($__componentOriginal41d51155e84d441a6a8cd32434074bb9); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>

<?php /**PATH C:\Users\franc\Desktop\ORDENRI\resources\views/auth/register.blade.php ENDPATH**/ ?>