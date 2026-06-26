<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Artículos del editor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ruta protegida con <code>verificar.rol:editor</code>.</p>
                    <p class="text-2xl font-semibold">Acceso concedido al rol editor.</p>
                    <p>Desde aquí se puede mostrar contenido reservado para edición y revisión.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>