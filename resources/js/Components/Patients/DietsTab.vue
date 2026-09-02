<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({

    patient: {
        type: Object,
        required: true,
    },

})
</script>

<template>

<div class="space-y-6">

    <!-- Encabezado -->

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-xl font-semibold text-slate-800">
                Planes alimenticios
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Historial de planes nutricionales del paciente.
            </p>

        </div>

        <Link
            href="#"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
        >
            Nuevo plan
        </Link>

    </div>

    <!-- Sin registros -->

    <div
        v-if="!patient.diets || patient.diets.length === 0"
        class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center"
    >

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-200">

            🍽️

        </div>

        <h3 class="mt-5 text-lg font-semibold text-slate-700">
            No existen planes alimenticios
        </h3>

        <p class="mt-2 text-slate-500">
            Crea el primer plan nutricional para este paciente.
        </p>

    </div>

    <!-- Lista -->

    <div
        v-else
        class="space-y-5"
    >

        <div
            v-for="diet in patient.diets"
            :key="diet.id"
            class="rounded-2xl border border-slate-200 bg-white p-6 transition hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-semibold text-slate-800">

                        {{ diet.name }}

                    </h3>

                    <p class="mt-1 text-sm text-slate-500">

                        {{ diet.created_at }}

                    </p>

                </div>

                <span
                    v-if="diet.active"
                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700"
                >
                    Activo
                </span>

                <span
                    v-else
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"
                >
                    Histórico
                </span>

            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-3">

                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Objetivo
                    </p>

                    <p class="mt-1 font-medium">

                        {{ diet.goal }}

                    </p>

                </div>

                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Calorías
                    </p>

                    <p class="mt-1 font-medium">

                        {{ diet.calories }}

                        kcal

                    </p>

                </div>

                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Comidas
                    </p>

                    <p class="mt-1 font-medium">

                        {{ diet.meals_count }}

                    </p>

                </div>

            </div>

            <div class="mt-6 flex gap-3">

                <Link
                    href="#"
                    class="rounded-lg border border-emerald-600 px-4 py-2 text-sm font-medium text-emerald-600 hover:bg-emerald-50"
                >
                    Ver plan
                </Link>

                <Link
                    href="#"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                >
                    Duplicar
                </Link>

                <Link
                    href="#"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                >
                    PDF
                </Link>

            </div>

        </div>

    </div>

</div>

</template>
