<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    assets: any[];
    users: any[];
}>();

const form = useForm({
    asset_id: '',
    user_id: '',
    assigned_at: '',
    condition_on_delivery: '',
    signature: '',
});

const submit = () => {
    form.post('/assignments');
};
</script>

<template>
    <Head title="Nueva Asignación" />

    <div class="p-4 md:p-8 min-h-screen bg-slate-950 text-white">
        <div class="max-w-3xl mx-auto bg-slate-900 border border-slate-800 rounded-xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-800/60 bg-slate-900/50">
                <h2 class="text-xl font-bold text-white">Registrar Nueva Asignación</h2>
            </div>

            <form @submit.prevent="submit" class="p-6 space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Activo</label>
                        <select
                            v-model="form.asset_id"
                            class="w-full rounded-lg border border-slate-800 bg-slate-950 text-white p-2.5 text-sm focus:border-slate-700 focus:ring-1 focus:ring-slate-700"
                            required
                        >
                            <option value="" disabled>Seleccione un activo...</option>
                            <option v-for="asset in props.assets" :key="asset.id" :value="asset.id">
                                {{ asset.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.asset_id" class="text-red-500 text-xs mt-1">{{ form.errors.asset_id }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Usuario Asignado</label>
                        <select
                            v-model="form.user_id"
                            class="w-full rounded-lg border border-slate-800 bg-slate-950 text-white p-2.5 text-sm focus:border-slate-700 focus:ring-1 focus:ring-slate-700"
                            required
                        >
                            <option value="" disabled>Seleccione un usuario...</option>
                            <option v-for="user in props.users" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.user_id" class="text-red-500 text-xs mt-1">{{ form.errors.user_id }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Fecha de Asignación</label>
                        <input
                            v-model="form.assigned_at"
                            type="date"
                            class="w-full rounded-lg border border-slate-800 bg-slate-950 text-white p-2.5 text-sm focus:border-slate-700 focus:ring-1 focus:ring-slate-700 [color-scheme:dark]"
                            required
                        />
                        <div v-if="form.errors.assigned_at" class="text-red-500 text-xs mt-1">{{ form.errors.assigned_at }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Condición de Entrega</label>
                        <textarea
                            v-model="form.condition_on_delivery"
                            rows="3"
                            class="w-full rounded-lg border border-slate-800 bg-slate-950 text-white p-2.5 text-sm focus:border-slate-700 focus:ring-1 focus:ring-slate-700"
                            placeholder="Detalles sobre el estado físico del equipo..."
                            required
                        ></textarea>
                        <div v-if="form.errors.condition_on_delivery" class="text-red-500 text-xs mt-1">{{ form.errors.condition_on_delivery }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Firma (Nombre de quien recibe)</label>
                        <input
                            v-model="form.signature"
                            type="text"
                            class="w-full rounded-lg border border-slate-800 bg-slate-950 text-white p-2.5 text-sm focus:border-slate-700 focus:ring-1 focus:ring-slate-700"
                            placeholder="Nombre completo"
                        />
                        <div v-if="form.errors.signature" class="text-red-500 text-xs mt-1">{{ form.errors.signature }}</div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800/60">
                    <Link
                        href="/assignments"
                        class="px-5 py-2.5 text-sm font-medium text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors"
                    >
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-950 bg-white hover:bg-slate-100 rounded-lg shadow-lg shadow-white/5 transition-all active:scale-95 disabled:opacity-50"
                    >
                        Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>