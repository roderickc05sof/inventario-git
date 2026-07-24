<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Vista {
    id_vista: number;
    name: string;
}

const props = defineProps<{
    vista: Vista;
}>();

const form = useForm({
    name: props.vista.name,
});

function submit() {
    form.put(`/vistas/${props.vista.id_vista}`);
}
</script>

<template>
    <Head title="Editar Vista" />

    <div class="max-w-3xl mx-auto p-6 md:p-10">

        <!-- Encabezado -->
        <div class="mb-8 border-b border-slate-800/60 pb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-white">
                Editar Vista
            </h1>

            <p class="mt-2 text-sm text-slate-400">
                Modifica el nombre de la vista.
            </p>
        </div>

        <!-- Formulario -->
        <form
            @submit.prevent="submit"
            class="bg-slate-900/40 border border-slate-800 rounded-xl p-8 shadow-xl space-y-8"
        >

            <div class="flex flex-col gap-2">
                <label class="text-xs font-medium text-slate-300">
                    Nombre de la Vista
                </label>

                <input
                    v-model="form.name"
                    type="text"
                    class="border border-slate-800 bg-slate-950 text-white rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                >

                <p
                    v-if="form.errors.name"
                    class="text-red-500 text-sm"
                >
                    {{ form.errors.name }}
                </p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 border-t border-slate-800 pt-6">

                <Link
                    href="/vistas"
                    class="px-4 py-2 rounded-lg text-slate-400 hover:text-white transition"
                >
                    Cancelar
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg font-semibold transition disabled:opacity-50"
                >
                    Guardar Cambios
                </button>

            </div>

        </form>

    </div>
</template>