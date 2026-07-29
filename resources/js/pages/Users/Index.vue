<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    users: any;
    search?: string;
}>();

const search = ref(props.search ?? '');

const buscar = debounce(() => {
    router.get('/users', {
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
}, 300);

function destroy(id: number) {
    if (confirm('¿Eliminar este usuario?')) {
        router.delete(`/users/${id}`);
    }
}
</script>

<template>
    <Head title="Usuarios" />

    <div class="p-4 md:p-8 min-h-screen bg-slate-950 text-white">
        <div class="max-w-7xl mx-auto space-y-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-800/60 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Gestión de Usuarios
                    </h1>
                    <p class="mt-2 text-sm text-slate-400">
                        Administra las cuentas de acceso y roles del sistema.
                    </p>
                </div>

                <Link
                    href="/users/create"
                    class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-950 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-lg shadow-white/5 transition-all duration-150 active:scale-95 self-start sm:self-auto"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    Nuevo Usuario
                </Link>
            </div>

            <div>
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
                        placeholder="Buscar por nombre, correo o rol..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-800 bg-slate-950/60 text-white placeholder:text-slate-600 shadow-inner text-sm focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all"
                    >
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-800 bg-slate-900 shadow-xl">
                <table class="w-full border-collapse text-left text-sm text-white">
                    <thead class="bg-slate-800 text-xs uppercase text-gray-400">
                        <tr>
                            <th class="p-4 font-semibold">Usuario</th>
                            <th class="p-4 font-semibold">Correo Electrónico</th>
                            <th class="p-4 font-semibold">Rol</th>
                            <th class="p-4 font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800">
                        <tr v-if="!props.users?.data || props.users.data.length === 0">
                            <td colspan="4" class="p-8 text-center text-slate-500 text-sm">
                                No se encontraron usuarios registrados.
                            </td>
                        </tr>

                        <tr 
                            v-else
                            v-for="user in props.users.data"
                            :key="user.id" 
                            class="hover:bg-slate-800/50 transition-colors"
                        >
                            <td class="p-4 font-medium flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-semibold text-slate-300 text-xs uppercase">
                                    {{ user.name.charAt(0) }}
                                </div>
                                <span class="text-white font-semibold">{{ user.name }}</span>
                            </td>

                            <td class="p-4 text-gray-300">
                                {{ user.email }}
                            </td>

                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border border-slate-700 bg-slate-800/80 text-slate-300">
                                    {{ user.role?.descripcion || user.role?.name || 'Sin Rol' }}
                                </span>
                            </td>

                            <td class="p-4 flex items-center justify-center space-x-2">
                                <Link
                                    :href="`/users/${user.id}/edit`"
                                    class="p-2 rounded-md bg-slate-800/80 text-yellow-500 hover:bg-yellow-500 hover:text-white transition-colors"
                                    title="Editar"
                                >
                                    <Pencil class="w-4 h-4" />
                                </Link>

                                <button
                                    @click="destroy(user.id)"
                                    class="p-2 rounded-md bg-slate-800/80 text-red-500 hover:bg-red-600 hover:text-white transition-colors cursor-pointer"
                                    title="Eliminar"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="props.users?.links && props.users.links.length > 3" class="flex justify-center py-4 border-t border-gray-800 gap-1.5 bg-slate-900/50">
                    <template v-for="link in props.users.links" :key="link.label">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="px-3.5 py-2 text-xs font-medium border border-slate-800 rounded-md bg-slate-950/40 text-slate-300 hover:bg-slate-800 hover:text-white transition-all"
                            :class="{ 'bg-white !text-slate-950 font-bold border-white': link.active }"
                        >
                            <span v-html="link.label" />
                        </Link>

                        <span
                            v-else
                            class="px-3.5 py-2 text-xs font-medium border border-slate-900/50 rounded-md text-slate-600 cursor-not-allowed select-none"
                        >
                            <span v-html="link.label" />
                        </span>
                    </template>
                </div>
            </div>

        </div>
    </div>
</template>