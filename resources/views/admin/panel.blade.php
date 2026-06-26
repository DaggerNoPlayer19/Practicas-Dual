<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Panel de administración
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ruta protegida con <code>verificar.rol:admin</code>.</p>
                    <p class="text-2xl font-semibold">Acceso concedido al rol administrador.</p>
                    <p>Esta pantalla sirve como evidencia de que el middleware está validando correctamente el rol del usuario autenticado.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>