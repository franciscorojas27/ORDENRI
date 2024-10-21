<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['users', 'select', 'excluedtitle', 'id_name']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['users', 'select', 'excluedtitle', 'id_name']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<select name="<?php echo e($id_name); ?>" id="<?php echo e($id_name); ?>"
    class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none"
    <?php echo e(Auth::user()->jobTitle->title !== 'Supervisor' ? '' : ''); ?>>
    <option value="" <?php echo e(is_null($select) ? 'selected' : 'disabled'); ?>

        class="text-gray-500 dark:text-gray-400">
        <?php echo e($select['id']['name'] ?? __('Select an option')); ?>

    </option>

    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($user->jobTitle->title !== $excluedtitle): ?>
            <option value="<?php echo e($user->id); ?>" class="text-black"
                <?php echo e(isset($select) && $user->id == $select['id'] ? 'selected' : ''); ?>>
                <?php echo e($user->name .' '.$user->last_name); ?>

            </option>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

<?php /**PATH C:\Users\franc\Desktop\ORDENRI\resources\views/components/edit-select.blade.php ENDPATH**/ ?>