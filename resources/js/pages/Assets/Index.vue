<script setup lang="ts">
import { Head,router } from '@inertiajs/vue3';
import { ref } from 'vue'
const props = defineProps<{
    assets: any;
    search?: string;
}>();

const search = ref(props.search ?? '');
function buscar() {
    router.get('/assets', {
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
}

function destroy(id: number) {
    if (confirm('¿Eliminar este activo?')) {
        router.delete(`/assets/${id}`);
    }
}
</script>

<template>
    <Head title="Assets" />

    <div class="p-6">
        <div class="max-w-7xl mx-auto p-6 md:p-10">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 border-b border-slate-800/60 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Inventario de Activos
                    </h1>
                    <p class="mt-2 text-sm text-slate-400">
                        Gestiona y controla los equipos de hardware y TI de la empresa.
                    </p>
                </div>

                <a
                    href="/assets/create"
                    class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-950 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-lg shadow-white/5 transition-all duration-150 active:scale-95"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Activo
                </a>
            </div>

            <div class="mb-8">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
                        </svg>
                    </span>
                    
                    <input
                        v-model="search"
                        @input="buscar"
                        type="text"
                        placeholder="Buscar activos por nombre, serie o código..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-800 bg-slate-950/60 text-white placeholder:text-slate-600 shadow-inner text-sm focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all"
                    >
                </div>
            </div>

        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-800">
            <table class="w-full border-collapse bg-slate-900 text-left text-sm text-white">
                <thead class="bg-slate-800 text-xs uppercase text-gray-400">
                    <tr>
                        <th class="p-4 font-semibold">Nombre</th>
                        <th class="p-4 font-semibold">Categoría</th>
                        <th class="p-4 font-semibold">Fabricante</th>
                        <th class="p-4 font-semibold">Ubicación</th>
                        <th class="p-4 font-semibold">Estado</th>
                        <th class="p-4 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">
                    <tr v-if="props.assets.data.length === 0">
                        <td colspan="6" class="p-8 text-center text-slate-500 text-sm">
                            No se encontraron activos que coincidan con la búsqueda.
                        </td>
                    </tr>

                    <tr 
                        v-else
                       v-for="asset in props.assets.data"
                        :key="asset.id"
                        class="hover:bg-slate-800/50 transition-colors"
                    >
                        <td class="p-4 font-medium">{{ asset.name }}</td>
                        <td class="p-4 text-gray-300">{{ asset.category?.name }}</td>
                        <td class="p-4 text-gray-300">{{ asset.manufacturer?.name }}</td>
                        <td class="p-4 text-gray-300">{{ asset.location?.name }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center rounded-md bg-blue-400/10 px-2 py-1 text-xs font-medium text-blue-400 ring-1 ring-inset ring-blue-400/30">
                                {{ asset.status?.name }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a
                                :href="`/assets/${asset.id}/edit`"
                                class="inline-flex items-center rounded bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1.5 text-xs font-semibold transition-colors"
                            >
                                Editar
                            </a>

                            <button
                                @click="destroy(asset.id)"
                                class="inline-flex items-center rounded bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-xs font-semibold transition-colors cursor-pointer"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-center mt-6 gap-2">

    <template
        v-for="link in props.assets.links"
        :key="link.label"
    >

        <a
            v-if="link.url"
            :href="link.url"
            v-html="link.label"
            class="px-3 py-2 border rounded"
        />

        <span
            v-else
            v-html="link.label"
            class="px-3 py-2 text-gray-500"
        />

    </template>

</div>
        </div>
    </div>
</template>