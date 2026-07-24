<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';


interface Role {
    id_role: number;
    descripcion: string;
}

interface Vista {
    id_vista: number;
    name: string;
}

const props = defineProps<{
    roles: Role[];
    vistas: Vista[];
    selectedRole: number | null;
    selectedPermissions: number[];
}>();

const form = useForm({
    id_role: props.selectedRole ?? '',
    vistas: props.selectedPermissions ?? [],
});


function submit() {
    form.post('/permisos');
}
</script>

<template>

<Head title="Permisos"/>

<div class="max-w-5xl mx-auto p-10">

<h1 class="text-3xl font-bold mb-8">
Permisos
</h1>

<form
    @submit.prevent="submit"
    class="space-y-8 bg-slate-900 border border-slate-700 rounded-xl p-8"
>

<div>

<label>Rol</label>

<select
    v-model="form.id_role"
    class="w-full mt-2 rounded border bg-slate-950 p-2"
>

<option value="">Seleccione...</option>

<option
v-for="role in roles"
:key="role.id_role"
:value="role.id_role"
>
{{ role.descripcion }}
</option>

</select>

</div>

<div>

<h2 class="font-semibold mb-4">
Vistas disponibles
</h2>

<div class="grid grid-cols-2 gap-3">

<label
v-for="vista in vistas"
:key="vista.id_vista"
class="flex items-center gap-2"
>

<input
type="checkbox"
:value="vista.id_vista"
v-model="form.vistas"
/>

{{ vista.name }}

</label>

</div>

</div>

<button
class="bg-blue-600 px-5 py-2 rounded"
>
Guardar
</button>

</form>

</div>

</template>