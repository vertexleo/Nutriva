<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import DietForm from '@/Components/Diets/DietForm.vue';

defineProps({
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
    <Head title="Nuevo Plan Nutricional" />

    <AppLayout>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">
                Diseñar Nuevo Plan Nutricional
            </h1>

            <p class="text-sm text-slate-500">
                Calcula el requerimiento energético y diseña la alimentación personalizada del paciente.
            </p>
        </div>

        <DietForm
            :patients="patients"
            :foods="foods"
        />

    </AppLayout>
</template>
