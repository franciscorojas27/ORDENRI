@foreach ($counts as $key => $count)
    <div class="flex animate-zoom-in bg-white dark:bg-gray-900 p-4 rounded-lg shadow-md items-start justify-between">
        <a href="{{ route('dashboard') }}">
            <div>
                <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400">
                    {{ __('Número de órdenes de servicio para :attribute', ['attribute' => __($key)]) }}</h3>
                <p class="text-4xl font-extrabold mt-3">{{ $count }}</p>
            </div>
        </a>
        <div class="flex items-center">
            @switch($key)
                @case('Evaluación')
                    <svg data-slot="icon" fill="none" class="text-black dark:text-white" with="40" height="40"
                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z">
                        </path>
                    </svg>
                @break

                @case('Pendiente')
                    <svg data-slot="icon" class="text-black dark:text-white" with="40" height="40" fill="currentColor"
                        viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M2 3a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z"></path>
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 7.5h16l-.811 7.71a2 2 0 0 1-1.99 1.79H4.802a2 2 0 0 1-1.99-1.79L2 7.5ZM7 11a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Z">
                        </path>
                    </svg>
                @break

                @case('Finalizada')
                    <svg data-slot="icon" fill="none" class="text-black dark:text-white" with="40" height="40"
                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                    </svg>
                @break

                @case('Rechazada')
                    <svg data-slot="icon" fill="none" class="text-black dark:text-white" with="40" height="40"
                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"></path>
                    </svg>
                @break

                @case('En Proceso')
                    
                    <svg data-slot="icon" fill="none" class="text-black dark:text-white" with="40" height="40"
                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                        </path>
                    </svg>
                @break

                @case('Cerrada')
                    <svg data-slot="icon" fill="none" class="text-black dark:text-white" with="40" height="40"
                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                        </path>
                    </svg>
                @break
            @endswitch
        </div>
    </div>
@endforeach
