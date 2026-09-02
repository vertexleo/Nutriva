<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({

    patient: Object,

})
</script>

<template>

<Head :title="patient.full_name" />

<AppLayout>

<div class="space-y-8">

    <!-- Encabezado -->

    <div
        class="rounded-2xl border border-slate-200 bg-white p-8"
    >

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-5">

                <!-- Avatar -->

                <div
                    class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-500 text-3xl font-bold text-white"
                >
                    {{ patient.first_name.charAt(0) }}
                </div>

                <div>

                    <h1
                        class="text-3xl font-bold text-slate-800"
                    >
                        {{ patient.full_name }}
                    </h1>

                    <p
                        class="mt-1 text-slate-500"
                    >
                        {{ patient.age }} años
                        •
                        {{ patient.gender }}
                    </p>

                    <p
                        class="mt-2 text-sm text-slate-500"
                    >
                        DNI:
                        {{ patient.dni }}
                    </p>

                </div>

            </div>

            <div>

                <Link

                    :href="route('patients.edit', patient.id)"

                    class="rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white hover:bg-emerald-700"

                >

                    Editar paciente

                </Link>

            </div>

        </div>

    </div>

    <!-- Resumen -->

    <div
        class="grid gap-6 md:grid-cols-4"
    >

        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Peso actual
            </p>

            <h2 class="mt-2 text-3xl font-bold">

                {{ patient.last_record?.weight ?? '--' }}

                kg

            </h2>

        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                IMC
            </p>

            <h2 class="mt-2 text-3xl font-bold">

                {{ patient.last_record?.bmi ?? '--' }}

            </h2>

        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Objetivo
            </p>

            <h2 class="mt-2 text-lg font-semibold">

                {{ patient.clinical_history?.goals ?? '--' }}

            </h2>

        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Próxima cita
            </p>

            <h2 class="mt-2 text-lg font-semibold">

                Sin programar

            </h2>

        </div>

    </div>

    <!-- Tabs -->

    <div
        class="rounded-2xl border border-slate-200 bg-white"
    >

        <div
            class="flex border-b"
        >

            <button class="border-b-2 border-emerald-600 px-6 py-4 font-semibold text-emerald-600">

                Datos personales

            </button>

            <button class="px-6 py-4 text-slate-500">

                Historia clínica

            </button>

            <button class="px-6 py-4 text-slate-500">

                Evaluaciones

            </button>

            <button class="px-6 py-4 text-slate-500">

                Planes

            </button>

            <button class="px-6 py-4 text-slate-500">

                Citas

            </button>

            <button class="px-6 py-4 text-slate-500">

                Archivos

            </button>

            <button class="px-6 py-4 text-slate-500">

                Evolución

            </button>

        </div>

        <div
            class="p-8"
        >

            <h2
                class="mb-6 text-xl font-semibold"
            >
                Datos personales
            </h2>

            <div
                class="grid gap-6 md:grid-cols-2"
            >

                <div>

                    <p class="text-sm text-slate-500">
                        Teléfono
                    </p>

                    <p class="font-medium">

                        {{ patient.phone }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Correo
                    </p>

                    <p class="font-medium">

                        {{ patient.email }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Ocupación
                    </p>

                    <p class="font-medium">

                        {{ patient.occupation }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Dirección
                    </p>

                    <p class="font-medium">

                        {{ patient.address }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</AppLayout>

</template>
