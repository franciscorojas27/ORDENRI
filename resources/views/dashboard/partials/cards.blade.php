<div
    class="bg-white dark:bg-gray-900 p-4 rounded-md shadow-md hover:shadow-lg transition-all duration-300 border dark:border-gray-900">
    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h4>
    <div class="mt-3 text-gray-800 dark:text-gray-300">
        <p class="text-md font-medium">Meta: 
            <span class="font-bold {{ $metaColor }}">{{ $meta }}</span>
        </p>
        <p class="text-md font-medium mt-1">Indicador: 
            <span class="font-bold {{ $indicatorColor }}">{{ $indicator }}</span>
        </p>
    </div>
    <div class="mt-4">
        <svg class="w-full h-5" viewBox="0 0 100 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="{{ $progress }}" height="6" fill="#F7DC6F" rx="3">
                <animate attributeName="width" from="0%" to="{{ $progress }}" dur="2s" fill="freeze" />
            </rect>
        </svg>
    </div>
    <p class="mt-3 text-gray-900 dark:text-gray-400">{{ $description }}</p>
</div>
