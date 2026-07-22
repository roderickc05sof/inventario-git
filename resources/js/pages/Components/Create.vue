<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

interface Option {
    id: number;
    name: string;
}

defineProps<{
    assets: Option[];
    componentTypes: Option[];
}>();

const form = useForm({
    serial_number: '',
    asset_id: '',
    component_type_id: '',
    brand: '',
    specifications: '',

});

function submit() {
    form.post('/components');
}
</script>

<template>
    <Head title="Nuevo Componente" />

    <div class="max-w-4xl mx-auto p-6 md:p-10">

        <div class="mb-8 border-b border-slate-800/60 pb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                Crear Componente
            </h1>

            <p class="mt-2 text-sm text-slate-400">
                Registra un nuevo componente para un activo del inventario.
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-slate-900/40 border border-slate-800/80 rounded-xl p-6 md:p-8 shadow-2xl backdrop-blur-sm space-y-8"
        >

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">
                    Información del Componente
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">
                            Número de Serie
                        </label>

                        <input
                            type="text"
                            v-model="form.serial_number"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                            placeholder="Ej. RAM-0001"
                        >
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">
                            Marca
                        </label>

                        <input
                            type="text"
                            v-model="form.brand"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                            placeholder="Ej. Kingston"
                        >
                    </div>

                </div>
            </div>

            <div class="border-t border-slate-800/50 pt-6">

                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">
                    Asociación
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">
                            Activo
                        </label>

                        <select
                            v-model="form.asset_id"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                        >
                            <option value="">Seleccione un activo</option>

                            <option
                                v-for="asset in assets"
                                :key="asset.id"
                                :value="asset.id"
                            >
                                {{ asset.name }}
                            </option>

                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">
                            Tipo de Componente
                        </label>

                        <select
                            v-model="form.component_type_id"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                        >
                            <option value="">Seleccione un tipo</option>

                            <option
                                v-for="type in componentTypes"
                                :key="type.id"
                                :value="type.id"
                            >
                                {{ type.name }}
                            </option>

                        </select>
                    </div>

                </div>

            </div>

            <div class="border-t border-slate-800/50 pt-6">

                <label class="text-xs font-medium text-slate-300">
                    Especificaciones (JSON)
                </label>

                <textarea
                    rows="6"
                    v-model="form.specifications"
                    class="border border-slate-800 bg-slate-950/60 text-white rounded-lg p-3 w-full"
                    placeholder='{"capacidad":"16GB","tipo":"DDR4"}'
                ></textarea>

            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-slate-800/60">

                <a
                    href="/components"
                    class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-400 hover:text-white"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="bg-white hover:bg-slate-100 text-slate-950 px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer"
                >
                    Guardar Componente
                </button>
               
            </div>

        </form>

    </div>
</template>