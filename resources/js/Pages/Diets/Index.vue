<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    diets: {
        type: Array,
        default: () => [],
    },
});

const statusLabel = (status) => {
    const labels = {
        active: 'Activo',
        draft: 'Borrador',
        completed: 'Completado',
    };

    return labels[status] ?? status;
};
</script>

<template>

    <Head title="Planes Nutricionales" />

    <AppLayout>

        <!-- Encabezado -->

        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <div class="flex items-center gap-3">

                    <h1 class="text-3xl font-bold text-slate-800">
                        Planes Nutricionales
                    </h1>

                    <span
                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700"
                    >
                        {{ diets.length }} planes
                    </span>

                </div>

                <p class="mt-2 text-slate-500">
                    Diseña, administra y realiza seguimiento de los planes alimenticios.
                </p>

            </div>

            <Link
                :href="route('diets.create')"
                class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                + Crear Plan Nutricional
            </Link>

        </div>


        <!-- Tabla -->

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Plan
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Paciente
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Objetivo
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <tr
                            v-for="diet in diets"
                            :key="diet.id"
                            class="transition hover:bg-slate-50"
                        >

                            <!-- Plan -->

                            <td class="px-6 py-5">

                                <div class="font-semibold text-slate-800">
                                    {{ diet.name }}
                                </div>

                                <div class="mt-1 text-xs text-slate-400">
                                    Plan #{{ diet.id }}
                                </div>

                            </td>


                            <!-- Paciente -->

                            <td class="px-6 py-5">

                                <div class="font-medium text-slate-700">
                                    {{ diet.patient?.first_name }}
                                    {{ diet.patient?.last_name }}
                                </div>

                                <div class="mt-1 text-xs text-slate-400">
                                    DNI: {{ diet.patient?.dni ?? '—' }}
                                </div>

                            </td>


                            <!-- Calorías -->

                            <td class="px-6 py-5">

                                <div class="font-bold text-emerald-600">
                                    {{ diet.target_calories ?? 0 }} kcal
                                </div>

                                <div class="mt-1 text-xs text-slate-400">
                                    Objetivo diario
                                </div>

                            </td>


                            <!-- Estado -->

                            <td class="px-6 py-5">

                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                    :class="{
                                        'bg-emerald-100 text-emerald-700':
                                            diet.status === 'active',

                                        'bg-amber-100 text-amber-700':
                                            diet.status === 'draft',

                                        'bg-slate-100 text-slate-600':
                                            diet.status === 'completed'
                                    }"
                                >
                                    {{ statusLabel(diet.status) }}
                                </span>

                            </td>


                            <!-- Acciones -->

                            <td class="px-6 py-5 text-right">

                                <Link
                                    :href="route('diets.edit', diet.id)"
                                    class="rounded-lg px-3 py-2 text-sm font-medium text-emerald-600 transition hover:bg-emerald-50"
                                >
                                    Editar
                                </Link>

                            </td>

                        </tr>


                        <!-- Estado vacío -->

                        <tr v-if="diets.length === 0">

                            <td
                                colspan="5"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto max-w-md">

                                    <div class="mb-4 text-4xl">
                                        🥗
                                    </div>

                                    <h3 class="font-semibold text-slate-700">
                                        No hay planes nutricionales
                                    </h3>

                                    <p class="mt-2 text-sm text-slate-400">
                                        Crea el primer plan nutricional para comenzar a trabajar con tus pacientes.
                                    </p>

                                    <Link
                                        :href="route('diets.create')"
                                        class="mt-5 inline-flex rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700"
                                    >
                                        Crear primer plan
                                    </Link>

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </AppLayout>

</template>
