<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sidebar with Dropdown</title>
        <script src="//unpkg.com/alpinejs" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">

        <div class="flex">
            <header class="order-1">
                @include('layouts.navigation')
            </header>
            <!-- Sidebar -->
            <aside class="w-64 bg-white text-black h-screen" x-data="{ open: {{ in_array(Route::currentRouteName(), ['menu.submenu1', 'menu.submenu2', 'menu.submenu3']) ? '1' : 'null' }} }">
                <!-- Sidebar Header -->
                <div class="px-4 py-4 text-lg font-bold border-b border-gray-700">My Sidebar</div>

                <!-- Navigation Links -->
                <nav class="mt-4">
                    <!-- Home Link -->
                    <a href="{{ route('order.index') }}"
                        class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('order.index') ? 'bg-gray-700' : '' }}">
                        Home
                    </a>

                    <!-- Dropdown Menu Item -->
                    <div>
                        <button @click="open = open === 1 ? null : 1"
                            class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-700 {{ in_array(Route::currentRouteName(), ['order.create', 'dashboard', 'order.group.index']) ? 'bg-gray-700' : '' }}">
                            <span>Menu</span>
                            <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': open === 1 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Content -->
                        <div x-show="open === 1" class="pl-6 mt-2">
                            <a href="{{ route('order.create') }}"
                                class="block px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('order.create') ? 'bg-blue-600' : '' }}">
                                Submenu 1
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                                Submenu 2
                            </a>
                            <a href="{{ route('order.group.index') }}"
                                class="block px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('order.group.index') ? 'bg-blue-600' : '' }}">
                                Submenu 3
                            </a>
                        </div>
                    </div>

                    <!-- Other Links -->
                    <a href="{{ route('admin-secure.index') }}"
                        class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin-secure.index') ? 'bg-gray-700' : '' }}">
                        About
                    </a>
                    <a href="{{ route('order.consultation.index') }}"
                        class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('order.consultation.index') ? 'bg-gray-700' : '' }}">
                        Contact
                    </a>
                </nav>
            </aside>
            @yield('navigation')
            <!-- Main Content Area -->
            <main class="flex-1">
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Architecto veniam ipsam quo, cumque enim
                    eos blanditiis deleniti sequi. Exercitationem labore assumenda accusantium dolor dignissimos dolore
                    a libero accusamus, perferendis voluptatem.
                    Laborum cum minus qui excepturi vero dolorum quibusdam eius iusto dolor eaque, aspernatur quisquam.
                    In eos quaerat explicabo accusamus debitis perspiciatis, praesentium magnam. Quibusdam neque beatae
                    incidunt provident placeat velit!
                    Enim consequuntur velit aliquam cum maxime itaque illo doloribus magni, quam corporis eos
                    consectetur repellendus quos? Quis ad, incidunt tempore pariatur necessitatibus voluptates harum
                    repudiandae ea molestias unde aut fugiat.
                    Magni blanditiis omnis libero est consequatur repellendus nam voluptatibus eos inventore eum facere
                    corrupti voluptate error, ea placeat! Odit eius ad iusto accusantium! Perferendis dolorem nisi
                    atque, voluptatibus ducimus asperiores.
                    Ad, eius! Voluptate odio officia a corrupti, illo eum perspiciatis ducimus natus consequuntur itaque
                    labore molestiae! Alias necessitatibus culpa est debitis earum? Molestiae dignissimos ipsam
                    recusandae id sapiente, quod rerum?
                    Voluptates reprehenderit, accusantium eos quibusdam deserunt minus alias deleniti beatae, nisi
                    obcaecati unde architecto quis eum qui tempore, ex ut sit adipisci. Reiciendis, soluta. Blanditiis
                    dolor itaque eveniet voluptatem sunt.
                    Quisquam molestias nemo eligendi quos amet vero excepturi, quibusdam praesentium ad incidunt
                    corporis, consectetur vel debitis doloribus ex non, voluptates magnam tenetur sit dicta libero
                    tempora doloremque. Eveniet, nesciunt perferendis.
                    Voluptatibus quisquam dolores accusamus hic harum culpa pariatur dicta sit quia fuga in sunt animi
                    enim a odit velit esse voluptatem natus impedit accusantium tempora magni obcaecati, ipsa
                    distinctio! Corporis!
                    Odio labore illo architecto tenetur magni hic iusto harum, dolorem ut, accusantium eaque assumenda
                    modi illum perspiciatis numquam consequatur fugiat recusandae quos! Atque, natus id aliquid illum
                    quae error! Fugiat!
                    Eos corporis animi numquam enim repellat perferendis ex quas accusamus, quisquam quam fuga corrupti
                    consectetur nulla dolores suscipit voluptatum deserunt? Accusamus dolore soluta tempore atque non
                    suscipit ipsum facilis earum!</p>
            </main>
        </div>
    </body>

</html>
