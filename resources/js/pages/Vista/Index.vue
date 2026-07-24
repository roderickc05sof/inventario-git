<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';


interface Vista {
    id_vista: number;
    name: string;
}

const props = defineProps<{
    vistas: {
        data: Vista[];
        links: any[];
    };
    search?: string;
}>();

// Creamos un ref reactivo inicializado con la prop search
const searchInput = ref(props.search ?? '');

function handleSearch() {
    router.get('/vistas', {
        search: searchInput.value,
    }, {
        preserveState: true,
        replace: true,
    });
}

function destroy(id: number) {
    if (confirm('¿Está seguro de eliminar esta vista?')) {
        router.delete(`/vistas/${id}`);
    }
}
</script>

<template>
    <Head title="Vistas" />

    <div class="max-w-7xl mx-auto p-6 md:p-10">

        <!-- Encabezado -->
        <div class="flex items-center justify-between mb-8 border-b border-slate-800 pb-6">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    Gestión de Vistas
                </h1>

                <p class="text-slate-400 mt-2">
                    Administra las vistas disponibles del sistema.
                </p>
            </div>

            <Link
                href="/vistas/create"
                class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold transition"
            >
                Nueva Vista
            </Link>
        </div>

        <!-- Buscador Corregido -->
        <div class="mb-6">
            <input
                v-model="searchInput"
                @input="handleSearch"
                type="text"
                placeholder="Buscar vista..."
                class="w-full md:w-80 rounded-lg border border-slate-700 bg-slate-900 text-white px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500"
            >
        </div>

        <!-- Tabla -->
        <div class="overflow-hidden rounded-xl border border-slate-800">
            <table class="w-full text-sm">
                <thead class="bg-slate-900">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nombre</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="vista in vistas?.data ?? []"
                        :key="vista.id_vista"
                        class="border-t border-slate-800 hover:bg-slate-900/50"
                    >
                        <td class="px-6 py-4 text-slate-300">
                            {{ vista.id_vista }}
                        </td>

                        <td class="px-6 py-4 text-white">
                            {{ vista.name }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="`/vistas/${vista.id_vista}/edit`"
                                    class="px-3 py-1 rounded bg-amber-500 hover:bg-amber-400 text-black font-semibold"
                                >
                                    Editar
                                </Link>

                                <button
                                    @click="destroy(vista.id_vista)"
                                    class="px-3 py-1 rounded bg-red-600 hover:bg-red-500 text-white font-semibold"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="!vistas?.data || vistas.data.length === 0">
                        <td colspan="3" class="text-center py-8 text-slate-400">
                            No hay vistas registradas.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginación Corregida (Previene links nulos) -->
        <div v-if="vistas?.links && vistas.links.length > 3" class="flex gap-2 mt-6 flex-wrap">
            <template v-for="(link, index) in vistas.links" :key="index">
                <!-- Solo renderiza <Link> si existe la URL -->
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="px-3 py-2 rounded border border-slate-700 text-white hover:bg-slate-800"
                    :class="{ 'bg-blue-600 border-blue-600': link.active }"
                >
                    <span v-html="link.label" />
                </Link>

                <!-- Si link.url es null (ej. 'Anterior' deshabilitado), muestra un span normal -->
                <span
                    v-else
                    class="px-3 py-2 rounded border border-slate-800 text-slate-600 cursor-not-allowed select-none"
                >
                    <span v-html="link.label" />
                </span>
            </template>
        </div>

    </div>
</template>