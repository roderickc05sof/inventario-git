<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
interface Option {
    id: number;
    name: string;
}
interface Asset {
    id: number;
    name: string;
    category_id: number;
    manufacturer_id: number;
    location_id: number;
    status_id: number;
    model_number: string;
    serial_number: string;
    inventory_tag: string;
    purchase_date: string;
    cost: string;
    notes: string;
}


const props = defineProps<{
    asset: Asset;
    categories: Option[];
    manufacturers: Option[];
    locations: Option[];
    statuses: Option[];
}>();
const form = useForm({
    name: props.asset.name,
    category_id: props.asset.category_id,
    manufacturer_id: props.asset.manufacturer_id,
    location_id: props.asset.location_id,
    status_id: props.asset.status_id,
    model_number: props.asset.model_number,
    serial_number: props.asset.serial_number,
    inventory_tag: props.asset.inventory_tag,
    purchase_date: props.asset.purchase_date,
    cost: props.asset.cost,
    notes: props.asset.notes,
});
function submit() {
    form.put(`/assets/${props.asset.id}`);
}

</script>

<template>
    <Head title="Editar Activo" />

    <div class="max-w-4xl mx-auto p-6 md:p-10">
        
        <div class="mb-8 border-b border-slate-800/60 pb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                Editar Activo
            </h1>
            <p class="mt-2 text-sm text-slate-400">
                Modifica los detalles y especificaciones del equipo seleccionado.
            </p>
        </div>

        <form @submit.prevent="submit" class="bg-slate-900/40 border border-slate-800/80 rounded-xl p-6 md:p-8 shadow-2xl backdrop-blur-sm space-y-8">
            
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">Información del Activo</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Nombre del Activo</label>
                        <input 
                            type="text" 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm placeholder:text-slate-600 shadow-inner"
                            v-model="form.name"
                            placeholder="Ej. Laptop Desarrollo - Sucursal"
                            required
                        >
                    </div>

                    <!-- Modelo -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Modelo</label>
                        <input 
                            type="text" 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm placeholder:text-slate-600 shadow-inner"
                            v-model="form.model_number"
                            placeholder="Ej. Latitude 5440"
                        >
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800/50 pt-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">Clasificación e Identificación</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Categoría</label>
                        <select 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm shadow-inner cursor-pointer"
                            v-model="form.category_id"
                            required
                        >
                            <option value="" disabled class="bg-slate-950 text-slate-500">Selecciona...</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id" class="bg-slate-900 text-white">{{ category.name }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Fabricante</label>
                        <select 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm shadow-inner cursor-pointer"
                            v-model="form.manufacturer_id"
                            required
                        >
                            <option value="" disabled class="bg-slate-950 text-slate-500">Selecciona...</option>
                            <option v-for="manufacturer in manufacturers" :key="manufacturer.id" :value="manufacturer.id" class="bg-slate-900 text-white">{{ manufacturer.name }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Ubicación</label>
                        <select 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm shadow-inner cursor-pointer"
                            v-model="form.location_id"
                            required
                        >
                            <option value="" disabled class="bg-slate-950 text-slate-500">Selecciona...</option>
                            <option v-for="location in locations" :key="location.id" :value="location.id" class="bg-slate-900 text-white">{{ location.name }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Estado</label>
                        <select 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm shadow-inner cursor-pointer"
                            v-model="form.status_id"
                            required
                        >
                            <option value="" disabled class="bg-slate-950 text-slate-500">Selecciona...</option>
                            <option v-for="status in statuses" :key="status.id" :value="status.id" class="bg-slate-900 text-white">{{ status.name }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Número de Serie</label>
                        <input 
                            type="text" 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm placeholder:text-slate-600 shadow-inner"
                            v-model="form.serial_number"
                            placeholder="Ej. BR54X93"
                        >
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Código de Inventario</label>
                        <input 
                            type="text" 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm placeholder:text-slate-600 shadow-inner"
                            v-model="form.inventory_tag"
                            placeholder="Ej. INV-2026-001"
                        >
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800/50 pt-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-blue-500 mb-4">Detalles Financieros</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Fecha de Compra</label>
                        <input 
                            type="date" 
                            class="border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm scheme-dark shadow-inner"
                            v-model="form.purchase_date"
                        >
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-slate-300">Costo de Adquisición (USD)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-sm">$</span>
                            <input 
                                type="number" 
                                step="0.01" 
                                class="pl-7 border border-slate-800 bg-slate-950/60 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm placeholder:text-slate-600 shadow-inner"
                                v-model="form.cost"
                                placeholder="0.00"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800/50 pt-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-slate-300">Notas Adicionales</label>
                    <textarea 
                        rows="3" 
                        class="border border-slate-800 bg-slate-950/60 text-white rounded-lg p-3 w-full focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 hover:border-slate-800 transition-all text-sm resize-none placeholder:text-slate-600 shadow-inner"
                        v-model="form.notes"
                        placeholder="Ingresa especificaciones técnicas, fallos conocidos, etc..."
                    ></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-800/60">
                <a 
                    href="/assets" 
                    class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-400 hover:text-white transition-colors"
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-lg shadow-blue-500/10 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/40 active:scale-95"
                >
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</template>