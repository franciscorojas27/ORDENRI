<!-- resources/views/components/filter-select.blade.php -->
@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'options' => [],
    'colorBackGround' => 'bg-gray-800',
    'selected' => null,
    'placeholder' => '-- Select --',
    'isRequired' => true,
])

<div class="flex-1 min-w-[200px]">
    <x-input-label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300" :value="__($label)" />
    <div class="relative">
        <select {{ $isRequired ? 'required' : '' }} id="{{ $id }}" name="{{ $name }}"
            class="block w-full py-3 pl-10 pr-3 text-base text-gray-900 bg-white dark:text-white  border-0 border-b-2 border-gray-300 dark:border-gray-700 appearance-none focus:outline-none focus:ring-0 focus:border-indigo-500 dark:{{$colorBackGround}}">
            <option value="" class="text-gray-500 dark:text-gray-400" disabled {{ $selected ? '' : 'selected' }}>
                -- {{ __($placeholder) }} --
            </option>
            @foreach ($options as $option)
                <option value="{{ $option['value'] }}" 
                    {{ $selected == $option['value'] ? 'selected' : '' }}>
                    {{ $option['label'] }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </div>
    </div>
</div>
