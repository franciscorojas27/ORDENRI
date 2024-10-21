<table class="min-w-[700px] w-full text-sm text-left select-text text-gray-900 dark:text-gray-100">
    <thead class="text-xs dark:text-gray-400 uppercase bg-blue-600  dark:bg-gray-700">
        <tr>
            <th scope="col" class="px-6 py-3">N° orden</th>
            <th scope="col" class="px-6 py-3">Tipo</th>
            <th scope="col" class="px-6 py-3">Area de resolucion</th>
            <th scope="col" class="px-6 py-3">Fecha de creacion</th>
            <th scope="col" class="px-6 py-3">Descripcion</th>
            <th scope="col" class="px-6 py-3">Estado</th>
            <th scope="col" class="px-6 py-3"></th>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['isAdmin', 'isSupervisor'], Auth::user())): ?> 
                <th scope="col" class="px-3 py-3"> </th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 mb-2">
                <td class="px-6 py-4"><?php echo e($order->id); ?></td>
                <td class="px-6 py-4"><?php echo e($order->type->type); ?></td>
                <td class="px-6 py-4"><?php echo e($order->resolutionArea->area); ?></td>
                <td class="px-6 py-4">
                    <?php echo e($order->created_at->format('d/m/Y')); ?><br><?php echo e($order->created_at->format('H:i')); ?>

                </td>
                <td class="px-6 py-4"><?php echo e($order->client_description); ?></td>
                <td class="px-6 py-4"><?php echo e($order->status->status); ?></td>
                <td class="px-6 py-4">
                    <a href="<?php echo e(route('order.show', $order)); ?>"
                        class="text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 py-2 px-4 rounded-md">
                        Ver
                    </a>
                </td>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['isAdmin', 'isSupervisor'], Auth::user())): ?> 
                    <td class="px-3 py-4">
                        <form id="delete-order-<?php echo e($order->id); ?>" action="<?php echo e(route('order.destroy', $order)); ?>"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <?php if (isset($component)) { $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-button','data' => ['onclick' => 'confirm(\'¿Seguro que deseas eliminar esta orden?\') || event.stopImmediatePropagation()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('danger-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['onclick' => 'confirm(\'¿Seguro que deseas eliminar esta orden?\') || event.stopImmediatePropagation()']); ?>
                                Eliminar
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $attributes = $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $component = $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php echo e($slot); ?>

<?php /**PATH C:\Users\franc\Desktop\ORDENRI\resources\views/components/table-order.blade.php ENDPATH**/ ?>