<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import DietForm from '@/Components/Diets/DietForm.vue';

defineProps({
    diet: {
        type: Object,
        required: true,
    },

    patients: {
        type: Array,
        default: () => [],
    },

    foods: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>

    <Head title="Editar Plan Nutricional" />

    <AppLayout>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">
                Editar Plan Nutricional
            </h1>

            <p class="text-sm text-slate-500">
                Modifica las metas, equivalentes y distribución alimentaria del paciente.
            </p>
        </div>

        <DietForm
            :diet="diet"
            :patients="patients"
            :foods="foods"
            :is-editing="true"
        />

    </AppLayout>

</template>
