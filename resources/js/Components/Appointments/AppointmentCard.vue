<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    appointment: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['delete']);

const patientName = () => {
    if (!props.appointment.patient) {
        return 'Paciente no encontrado';
    }

    return `${props.appointment.patient.first_name} ${props.appointment.patient.last_name}`;
};

const patientInitial = () => {
    return patientName().charAt(0).toUpperCase();
};

const formatDate = (date) => {
    if (!date) {
        return '-';
    }

    const [year, month, day] = date.split('-');

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

const deleteAppointment = () => {
    emit('delete', props.appointment);
};
</script>

<template>
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md"
    >

        <!-- Encabezado -->
        <div class="flex items-start justify-between gap-4">

            <div class="flex min-w-0 items-center gap-3">

                <!-- Avatar -->
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-emerald-100 font-semibold text-emerald-700"
                >
                    {{ patientInitial() }}
                </div>

                <!-- Paciente -->
                <div class="min-w-0">

                    <h3
                        class="truncate font-semibold text-slate-800"
                    >
                        {{ patientName() }}
                    </h3>

                    <p
                        v-if="appointment.patient?.dni"
                        class="mt-0.5 text-sm text-slate-500"
                    >
                        DNI: {{ appointment.patient.dni }}
                    </p>

                </div>

            </div>

            <!-- Estado -->
            <span
                class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold"
                :class="statusClass(appointment.status)"
            >
                {{ statusLabel(appointment.status) }}
            </span>

        </div>

        <!-- Información -->
        <div
            class="mt-5 grid grid-cols-2 gap-4 border-y border-slate-100 py-4"
        >

            <!-- Fecha -->
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Fecha
                </p>

                <p class="mt-1 font-semibold text-slate-700">
                    {{ formatDate(appointment.appointment_date) }}
                </p>

            </div>

            <!-- Hora -->
            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Hora
                </p>

                <p class="mt-1 font-semibold text-slate-700">
                    {{ formatTime(appointment.appointment_time) }}
                </p>

            </div>

        </div>

        <!-- Tipo -->
        <div class="mt-4">

            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Tipo de consulta
            </p>

            <p class="mt-1 text-sm font-medium text-slate-700">
                {{ typeLabel(appointment.type) }}
            </p>

        </div>

        <!-- Notas -->
        <div
            v-if="appointment.notes"
            class="mt-4 rounded-xl bg-slate-50 p-3"
        >

            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Observaciones
            </p>

            <p class="mt-1 line-clamp-2 text-sm text-slate-600">
                {{ appointment.notes }}
            </p>

        </div>

        <!-- Acciones -->
        <div class="mt-5 flex items-center justify-end gap-2">

            <!-- Ver -->
            <Link
                :href="route(
                    'appointments.show',
                    appointment.id
                )"
                class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
            >
                Ver
            </Link>

            <!-- Editar -->
            <Link
                :href="route(
                    'appointments.edit',
                    appointment.id
                )"
                class="rounded-lg px-3 py-2 text-sm font-medium text-emerald-600 transition hover:bg-emerald-50 hover:text-emerald-700"
            >
                Editar
            </Link>

            <!-- Eliminar -->
            <button
                type="button"
                @click="deleteAppointment"
                class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700"
            >
                Eliminar
            </button>

        </div>

    </div>
</template>
