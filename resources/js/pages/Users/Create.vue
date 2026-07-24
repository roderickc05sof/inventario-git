<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

interface Role {
    id_role: number;
    descripcion: string;
}

defineProps<{
    roles: Role[];
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    id_role: '',
});

function submit() {
    form.post('/users');
}
</script>


<template>
    <Head title="Crear Usuario" />

    <div class="max-w-4xl mx-auto p-6 md:p-10">

        <div class="mb-8 border-b border-slate-800/60 pb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                Crear Usuario
            </h1>

            <p class="mt-2 text-sm text-slate-400">
                Registra un nuevo usuario para el sistema.
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-slate-900/40 border border-slate-800/80 rounded-xl p-6 md:p-8 shadow-2xl backdrop-blur-sm space-y-8"
        >

            <!-- Información -->
            <div>

                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">
                    Información del Usuario
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Nombre -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-medium text-slate-300">
                            Nombre
                        </label>

                        <input
                            type="text"
                            v-model="form.name"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                            placeholder="Nombre completo"
                        >

                        <p
                            v-if="form.errors.name"
                            class="text-red-500 text-sm"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-medium text-slate-300">
                            Correo
                        </label>

                        <input
                            type="email"
                            v-model="form.email"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                            placeholder="correo@ejemplo.com"
                        >

                        <p
                            v-if="form.errors.email"
                            class="text-red-500 text-sm"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- Contraseña -->
            <div class="border-t border-slate-800/50 pt-6">

                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">
                    Seguridad
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-medium text-slate-300">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            v-model="form.password"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                        >

                        <p
                            v-if="form.errors.password"
                            class="text-red-500 text-sm"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-medium text-slate-300">
                            Confirmar contraseña
                        </label>

                        <input
                            type="password"
                            v-model="form.password_confirmation"
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                        >
                    </div>

                </div>

            </div>

            <!-- Rol -->
            <div class="border-t border-slate-800/50 pt-6">

                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">
                    Rol del Usuario
                </h2>

                <div class="flex flex-col gap-2">

                    <label class="text-xs font-medium text-slate-300">
                        Rol
                    </label>

                    <select
                        v-model="form.id_role"
                        class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2"
                    >
                        <option value="">
                            Seleccione un rol
                        </option>

                        <option
                            v-for="role in roles"
                            :key="role.id_role"
                            :value="role.id_role"
                        >
                            {{ role.descripcion }}
                        </option>

                    </select>

                    <p
                        v-if="form.errors.id_role"
                        class="text-red-500 text-sm"
                    >
                        {{ form.errors.id_role }}
                    </p>

                </div>

            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-800/60">

                <a
                    href="/users"
                    class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-400 hover:text-white"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-white hover:bg-slate-100 text-slate-950 px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer disabled:opacity-50"
                >
                    {{ form.processing ? 'Guardando...' : 'Guardar Usuario' }}
                </button>

            </div>

        </form>

    </div>
</template>