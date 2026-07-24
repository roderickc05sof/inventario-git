<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

interface Role {
    id_role: number;
    descripcion: string;
}

interface User {
    id: number;
    name: string;
    email: string;
    id_role: number;
}

const props = defineProps<{
    user: User;
    roles: Role[];
}>();

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    id_role: props.user.id_role,
});

function submit() {
    form.put(`/users/${props.user.id}`);
}
</script>

<template>
    <Head title="Editar Usuario" />

    <div class="max-w-4xl mx-auto p-6 md:p-10">

        <div class="mb-8 border-b border-slate-800/60 pb-6">
            <h1 class="text-3xl font-extrabold text-white">
                Editar Usuario
            </h1>

            <p class="mt-2 text-sm text-slate-400">
                Modifica la información del usuario.
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-slate-900/40 border border-slate-800 rounded-xl p-8 space-y-8"
        >

            <!-- Nombre y correo -->
            <div class="grid grid-cols-2 gap-6">

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-medium text-slate-300">
                        Nombre
                    </label>

                    <input
                        type="text"
                        v-model="form.name"
                        class="border border-slate-800 bg-slate-950 rounded-lg px-3 py-2 text-white"
                    >

                    <p class="text-red-500 text-sm">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-medium text-slate-300">
                        Correo
                    </label>

                    <input
                        type="email"
                        v-model="form.email"
                        class="border border-slate-800 bg-slate-950 rounded-lg px-3 py-2 text-white"
                    >

                    <p class="text-red-500 text-sm">
                        {{ form.errors.email }}
                    </p>
                </div>

            </div>

            <!-- Contraseñas -->
            <div class="grid grid-cols-2 gap-6">

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-medium text-slate-300">
                        Nueva contraseña
                    </label>

                    <input
                        type="password"
                        v-model="form.password"
                        class="border border-slate-800 bg-slate-950 rounded-lg px-3 py-2 text-white"
                    >

                    <small class="text-slate-500">
                        Déjalo vacío si no deseas cambiarla.
                    </small>

                    <p class="text-red-500 text-sm">
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
                        class="border border-slate-800 bg-slate-950 rounded-lg px-3 py-2 text-white"
                    >
                </div>

            </div>

            <!-- Rol -->
            <div class="flex flex-col gap-2">

                <label class="text-xs font-medium text-slate-300">
                    Rol
                </label>

                <select
                    v-model="form.id_role"
                    class="border border-slate-800 bg-slate-950 rounded-lg px-3 py-2 text-white"
                >
                    <option
                        v-for="role in roles"
                        :key="role.id_role"
                        :value="role.id_role"
                    >
                        {{ role.descripcion }}
                    </option>
                </select>

                <p class="text-red-500 text-sm">
                    {{ form.errors.id_role }}
                </p>

            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-800">

                <a
                    href="/users"
                    class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-400 hover:text-white"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold"
                    :disabled="form.processing"
                >
                    Guardar Cambios
                </button>

            </div>

        </form>

    </div>
</template>