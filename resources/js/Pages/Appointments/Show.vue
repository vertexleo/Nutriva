<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    appointment: {
        type: Object,
        required: true,
    },
});

const patientName = () => {
    if (!props.appointment.patient) {
        return 'Paciente no encontrado';
    }

    return `${props.appointment.patient.first_name} ${props.appointment.patient.last_name}`;
};

const formatDate = (date) => {
    if (!date) return '-';

    // Toma solo los primeros 10 caracteres ("YYYY-MM-DD")
    const cleanDate = date.substring(0, 10);
    const [year, month, day] = cleanDate.split('-');

    if (!year || !month || !day) return date;

    return `${day}/${month}/${year}`;
};

const formatTime = (time) => {
    if (!time) {
        return '-';
    }

    return time.substring(0, 5);
};

const typeLabel = (type) => {
    const types = {
        initial: 'Consulta inicial',
        follow_up: 'Control / Seguimiento',
        evaluation: 'Evaluación nutricional',
        other: 'Otro',
    };

    return types[type] ?? type ?? '-';
};

const statusLabel = (status) => {
    const statuses = {
        scheduled: 'Programada',
        confirmed: 'Confirmada',
        completed: 'Completada',
        cancelled: 'Cancelada',
        no_show: 'No asistió',
    };

    return statuses[status] ?? status ?? '-';
};

const statusClass = (status) => {
    const classes = {
        scheduled: 'bg-blue-50 text-blue-700',
        confirmed: 'bg-emerald-50 text-emerald-700',
        completed: 'bg-slate-100 text-slate-700',
        cancelled: 'bg-red-50 text-red-700',
        no_show: 'bg-amber-50 text-amber-700',
    };

    return classes[status] ?? 'bg-slate-100 text-slate-700';
};
</script>

<template>
    <Head title="Detalle de cita" />

    <AppLayout>

        <!-- Encabezado -->
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Detalle de la cita
                </h1>

                <p class="mt-2 text-slate-500">
                    Información de la consulta nutricional.
                </p>
            </div>

            <div class="flex gap-3">

                <Link
                    :href="route('appointments.index')"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-slate-700 transition hover:bg-slate-100"
                >
                    Volver
                </Link>

                <Link
                    :href="route(
                        'appointments.edit',
                        appointment.id
                    )"
                    class="rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white transition hover:bg-emerald-700"
                >
                    Editar
                </Link>

            </div>

        </div>

        <!-- Contenido -->
        <div class="max-w-4xl space-y-6">

            <!-- Paciente -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-semibold text-slate-800">
                    Paciente
                </h2>

                <div class="mt-5 flex items-center gap-4">

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-lg font-bold text-emerald-700"
                    >
                        {{ patientName().charAt(0).toUpperCase() }}
                    </div>

                    <div>

                        <p class="text-lg font-semibold text-slate-800">
                            {{ patientName() }}
                        </p>

                        <p
                            v-if="appointment.patient?.dni"
                            class="text-sm text-slate-500"
                        >
                            DNI: {{ appointment.patient.dni }}
                        </p>

                    </div>

                </div>

            </div>

            <!-- Información de la cita -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-semibold text-slate-800">
                    Información de la cita
                </h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">

                    <!-- Fecha -->
                    <div>

                        <p class="text-sm text-slate-400">
                            Fecha
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ formatDate(appointment.appointment_date) }}
                        </p>

                    </div>

                    <!-- Hora -->
                    <div>

                        <p class="text-sm text-slate-400">
                            Hora
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ formatTime(appointment.appointment_time) }}
                        </p>

                    </div>

                    <!-- Tipo -->
                    <div>

                        <p class="text-sm text-slate-400">
                            Tipo de consulta
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ typeLabel(appointment.type) }}
                        </p>

                    </div>

                    <!-- Estado -->
                    <div>

                        <p class="text-sm text-slate-400">
                            Estado
                        </p>

                        <div class="mt-2">

                            <span
                                class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                :class="statusClass(appointment.status)"
                            >
                                {{ statusLabel(appointment.status) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Observaciones -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-semibold text-slate-800">
                    Observaciones
                </h2>

                <div class="mt-4 rounded-xl bg-slate-50 p-4">

                    <p
                        v-if="appointment.notes"
                        class="whitespace-pre-line text-sm leading-6 text-slate-600"
                    >
                        {{ appointment.notes }}
                    </p>

                    <p
                        v-else
                        class="text-sm italic text-slate-400"
                    >
                        No hay observaciones registradas.
                    </p>

                </div>

            </div>

        </div>

    </AppLayout>
</template>
