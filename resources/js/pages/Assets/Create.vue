<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
interface Option {
    id: number;
    name: string;
}

defineProps<{
    categories: Option[];
    manufacturers: Option[];
    locations: Option[];
    statuses: Option[];
}>();
const form = useForm({
    name: '',
    category_id: '',
    manufacturer_id: '',
    location_id: '',
    status_id: '',
    model_number: '',
    serial_number: '',
    inventory_tag: '',
    purchase_date: '',
    cost: '',
    notes: '',
});
function submit() {
    form.post('/assets');
}

</script>

<template>
    <Head title="Nuevo Activo" />

    <div class="p-6">
        <h1 class="text-2xl font-bold text-white">
            Crear Activo
        </h1>
        <p class="text-gray-400">Formulario de creación.</p>
    </div>

    <form  @submit.prevent="submit"
    class="mt-6 space-y-4 px-6">
        <div>
            <label class="block font-semibold mb-1 text-white">
                Nombre
            </label>
            <input type="text" class="border border-gray-700 bg-slate-900 text-white rounded p-2 w-full focus:outline-none focus:border-blue-500"
            v-model="form.name">
        </div>
        
        <div>
            <label class="block font-semibold mb-1 text-white">
                Categoría
            </label>
            <select class="border border-gray-700 bg-slate-900 text-white rounded p-2 w-full focus:outline-none focus:border-blue-500"
            v-model="form.category_id">
                <option 
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                    class="bg-slate-800 text-white" 
                >
                    {{ category.name }}
                </option>
            </select>
        </div>
        
        <div>
            <label class="block font-semibold mb-1 text-white">
                Fabricante
            </label>
            <select class="border border-gray-700 bg-slate-900 text-white rounded p-2 w-full focus:outline-none focus:border-blue-500"
            v-model="form.manufacturer_id">
                <option
                    v-for="manufacturer in manufacturers"
                    :key="manufacturer.id"
                    :value="manufacturer.id"
                    class="bg-slate-800 text-white" 
                >
                    {{ manufacturer.name }}
                </option>
            </select>
        </div>
        <div>
            <label class="block font-semibold mb-1 text-white">
              Ubicación  
            </label>
            <select class="border border-gray-700 bg-slate-900 text-white rounded p-2 w-full focus:outline-none focus:border-blue-500"
            v-model="form.location_id">
                <option 
                v-for="location in locations"
                :key="location.id"
                :value="location.id"
                class="bg-slate-800 text-white" >
                {{ location.name }}
                </option>
            </select>
        </div>

    <div>
    <label class="block font-semibold mb-1">
        Estado
    </label>

    <select class="border border-gray-700 bg-slate-900 text-white rounded p-2 w-full focus:outline-none focus:border-blue-500"
    v-model="form.status_id">
        <option
            v-for="status in statuses"
            :key="status.id"
            :value="status.id"
        >
            {{ status.name }}
        </option>
    </select>
    </div>

    <div>
    <label class="block font-semibold mb-1">
        Modelo
    </label>

    <input
        type="text"
        class="border rounded p-2 w-full"
        v-model="form.model_number"
    >
    </div>
    <div>
    <label class="block font-semibold mb-1">
        Número de Serie
    </label>

    <input
        type="text"
        class="border rounded p-2 w-full"
        v-model="form.serial_number"
    >
    </div>

    <div>
    <label class="block font-semibold mb-1">
        Código de Inventario
    </label>

    <input
        type="text"
        class="border rounded p-2 w-full"
        v-model="form.inventory_tag"
    >
    </div>

    <div>
    <label class="block font-semibold mb-1">
        Fecha de Compra
    </label>

    <input
        type="date"
        class="border rounded p-2 w-full"
        v-model="form.purchase_date"
    >
    </div>

    <div>
    <label class="block font-semibold mb-1">
        Costo
    </label>

    <input
        type="number"
        step="0.01"
        class="border rounded p-2 w-full"
        v-model="form.cost"
    >
    </div>

    <div>
    <label class="block font-semibold mb-1">
        Notas
    </label>

    <textarea
        rows="4"
        class="border rounded p-2 w-full"
        v-model="form.notes"
    ></textarea>
    </div>

    <div>
   <button
    type="submit"
    class="bg-blue-600 text-white px-4 py-2 rounded"
    >
    Guardar Activo
    </button>
    </div>

</form>
</template>