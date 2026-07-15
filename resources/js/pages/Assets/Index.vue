<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

defineProps<{
    assets: any[];
}>();
</script>

<template>
    <Head title="Assets" />

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Inventario de Activos</h1>

        <table class="border-collapse border border-gray-400 w-full">
            <thead>
                <tr>
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Categoría</th>
                    <th class="border p-2">Fabricante</th>
                    <th class="border p-2">Ubicación</th>
                    <th class="border p-2">Estado</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="asset in assets"
                    :key="asset.id"
                >
                    <td class="border p-2">{{ asset.name }}</td>
                    <td class="border p-2">{{ asset.category.name }}</td>
                    <td class="border p-2">{{ asset.manufacturer.name }}</td>
                    <td class="border p-2">{{ asset.location.name }}</td>
                    <td class="border p-2">{{ asset.status.name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>