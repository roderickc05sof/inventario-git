<!-- <script>
import { Head,router } from '@inertiajs/vue3';
import { ref } from 'vue'
const props = defineProps<{
    users: any;
    search?: string;
}>();

const search = ref(props.search ?? '');
function buscar() {
    router.get('/assets', {
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
}

function destroy(id: number) {
    if (confirm('¿Eliminar este activo?')) {
        router.delete(`/user/${id}`);
    }
}

</script>


<template> -->




















</template>