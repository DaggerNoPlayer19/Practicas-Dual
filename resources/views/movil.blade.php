<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Vista móvil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ruta de destino cuando el middleware detecta User-Agent de teléfono.</p>
                    <p class="text-2xl font-semibold">Contenido optimizado para móvil.</p>
                    <p>Desde esta pantalla se confirma la redirección automática hacia <code>/movil</code>.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>