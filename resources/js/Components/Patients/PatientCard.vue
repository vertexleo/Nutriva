<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({

    patient: {
        type: Object,
        required: true,
    },

})
</script>

<template>

<div
    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg"
>

    <!-- Encabezado -->

    <div class="flex items-center gap-4">

        <div
            class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-500 text-lg font-bold text-white"
        >

            {{ patient.first_name.charAt(0).toUpperCase() }}

        </div>

        <div class="flex-1">

            <h3
                class="text-lg font-semibold text-slate-800"
            >

                {{ patient.full_name }}

            </h3>

            <p
                class="text-sm text-slate-500"
            >

                {{ patient.age }} años

                •

                {{ patient.gender }}

            </p>

        </div>

        <span
            v-if="patient.active"
            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700"
        >

            Activo

        </span>

        <span
            v-else
            class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
        >

            Inactivo

        </span>

    </div>

    <!-- Información -->

    <div
        class="mt-6 space-y-3 text-sm"
    >

        <div class="flex justify-between">

            <span class="text-slate-500">
                DNI
            </span>

            <span class="font-medium">
                {{ patient.dni }}
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-slate-500">
                Teléfono
            </span>

            <span class="font-medium">
                {{ patient.phone || '--' }}
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-slate-500">
                Peso
            </span>

            <span class="font-medium">

                {{ patient.last_record?.weight ?? '--' }}

                kg

            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-slate-500">
                IMC
            </span>

            <span class="font-semibold text-emerald-600">

                {{ patient.last_record?.bmi ?? '--' }}

            </span>

        </div>

    </div>

    <!-- Acciones -->

    <div
        class="mt-6 flex gap-3"
    >

        <Link

            :href="route('patients.show', patient.id)"

            class="flex-1 rounded-xl border border-emerald-600 px-4 py-2 text-center font-medium text-emerald-600 transition hover:bg-emerald-50"

        >

            Ver ficha

        </Link>

        <Link

            :href="route('patients.edit', patient.id)"

            class="flex-1 rounded-xl bg-emerald-600 px-4 py-2 text-center font-medium text-white transition hover:bg-emerald-700"

        >

            Editar

        </Link>

    </div>

</div>

</template>
