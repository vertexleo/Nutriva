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
                Citas
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Historial y próximas citas del paciente.
            </p>

        </div>

        <Link
            href="#"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
        >

            Nueva cita

        </Link>

    </div>

    <!-- Sin citas -->

    <div
        v-if="!patient.appointments || patient.appointments.length === 0"
        class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center"
    >

        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-200 text-3xl"
        >
            📅
        </div>

        <h3 class="mt-5 text-lg font-semibold text-slate-700">
            No existen citas registradas
        </h3>

        <p class="mt-2 text-slate-500">
            Agenda la primera consulta para este paciente.
        </p>

    </div>

    <!-- Lista -->

    <div
        v-else
        class="space-y-4"
    >

        <div
            v-for="appointment in patient.appointments"
            :key="appointment.id"
            class="rounded-2xl border border-slate-200 bg-white p-6 transition hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-semibold text-slate-800">

                        {{ appointment.reason }}

                    </h3>

                    <p class="mt-1 text-sm text-slate-500">

                        {{ appointment.date }}

                        ·

                        {{ appointment.time }}

                    </p>

                </div>

                <!-- Estado -->

                <span
                    v-if="appointment.status === 'scheduled'"
                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700"
                >
                    Programada
                </span>

                <span
                    v-else-if="appointment.status === 'completed'"
                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700"
                >
                    Completada
                </span>

                <span
                    v-else-if="appointment.status === 'cancelled'"
                    class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                >
                    Cancelada
                </span>

                <span
                    v-else
                    class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700"
                >
                    No asistió
                </span>

            </div>

            <!-- Notas -->

            <div
                v-if="appointment.notes"
                class="mt-5 rounded-xl bg-slate-50 p-4"
            >

                <p class="text-sm text-slate-600">

                    {{ appointment.notes }}

                </p>

            </div>

            <!-- Acciones -->

            <div class="mt-6 flex gap-3">

                <Link
                    href="#"
                    class="rounded-lg border border-emerald-600 px-4 py-2 text-sm font-medium text-emerald-600 hover:bg-emerald-50"
                >

                    Ver

                </Link>

                <Link
                    href="#"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                >

                    Editar

                </Link>

                <Link
                    href="#"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                >

                    Reagendar

                </Link>

            </div>

        </div>

    </div>

</div>

</template>
