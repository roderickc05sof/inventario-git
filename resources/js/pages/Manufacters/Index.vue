<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { Trash2 } from 'lucide-vue-next';


defineProps<{
    manufacturers: { id: number, name: string }[];
}>();

const form = useForm({
    name: '',
});

const submit = () => {
    form.post('/manufacturers', {
        onSuccess: () => form.reset(),
    });
};

const deleteManufacturer = (id: number) => {
    if (confirm('¿Estás seguro de que deseas eliminar este fabricante?')) {
        form.delete(`/manufacturers/${id}`);
    }
};
</script>

<template>
    <Head title="Fabricantes" />

    <div class="p-4 md:p-8 min-h-screen bg-slate-950 text-white">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-800/60 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Gestión de Fabricantes
                    </h1>
                    <p class="mt-2 text-sm text-slate-400">
                        Administra las marcas o fabricantes del sistema.
                    </p>
                </div>
            </div>

            <div>
                <form @submit.prevent="submit" class="flex flex-col sm:flex-row gap-4 items-start">
                    <div class="relative w-full md:w-96">
                      <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
    <Plus class="w-4.5 h-4.5" />
</span>
                        
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Nombre del nuevo fabricante..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-800 bg-slate-950/60 text-white placeholder:text-slate-600 shadow-inner text-sm focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all"
                            required
                        >
                        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1.5 ml-1">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-950 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-lg shadow-white/5 transition-all duration-150 active:scale-95 disabled:opacity-50 self-start w-full sm:w-auto"
                    >
                        Guardar
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-800 bg-slate-900 shadow-xl">
                <table class="w-full border-collapse text-left text-sm text-white">
                    <thead class="bg-slate-800 text-xs uppercase text-gray-400">
                        <tr>
                            <th class="p-4 font-semibold">ID</th>
                            <th class="p-4 font-semibold">Nombre</th>
                            <th class="p-4 font-semibold text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800">
                        <tr v-if="!manufacturers || manufacturers.length === 0">
                            <td colspan="3" class="p-8 text-center text-slate-500 text-sm">
                                No hay fabricantes registrados aún.
                            </td>
                        </tr>

                        <tr 
                            v-else
                            v-for="manufacturer in manufacturers" 
                            :key="manufacturer.id" 
                            class="hover:bg-slate-800/50 transition-colors"
                        >
                            <td class="p-4 font-medium text-slate-400">{{ manufacturer.id }}</td>
                            <td class="p-4  text-gray-200 font-semibold">{{ manufacturer.name }}</td>
                            <td class="p-4 text-center space-x-2">
                                <button
                                     @click="deleteManufacturer(manufacturer.id)" 
                                    class="p-2 rounded-md bg-slate-800/80 text-red-500 hover:bg-red-600 hover:text-white transition-colors cursor-pointer"
                                    title="Eliminar"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
