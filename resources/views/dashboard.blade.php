<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto flex h-full w-full max-w-4xl flex-1 flex-col gap-4 rounded-xl p-4 sm:p-6">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">Dashboard</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Gestiona rápidamente el módulo de notas de jugadores desde este acceso directo.
            </p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Módulo de notas</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Ingresa al listado de jugadores y abre las notas de cada perfil.
            </p>

            @can('players.view')
                <a
                    href="{{ route('players.index') }}"
                    wire:navigate
                    class="mt-4 inline-flex items-center rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300"
                >
                    Ir al módulo de notas
                </a>
            @else

            @endcan
        </div>
    </div>
</x-layouts::app>
