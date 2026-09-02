<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    appointments: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['delete']);

const patientName = (appointment) => {
    if (!appointment.patient) {
        return 'Paciente no encontrado';
    }

    return `${appointment.patient.first_name} ${appointment.patient.last_name}`;
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
        scheduled: 'bg-blue-50 text-blue-700 ring-blue-600/20',
        confirmed: 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        completed: 'bg-slate-100 text-slate-700 ring-slate-600/20',
        cancelled: 'bg-red-50 text-red-700 ring-red-600/20',
        no_show: 'bg-amber-50 text-amber-700 ring-amber-600/20',
    };

    return classes[status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20';
};

const deleteAppointment = (appointment) => {
    emit('delete', appointment);
};
</script>

<template>
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Tabla -->
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <!-- Encabezado -->
                <thead class="bg-slate-50">

                    <tr>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            Paciente
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            Fecha
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            Hora
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            Tipo
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            Estado
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            Acciones
                        </th>

                    </tr>

                </thead>

                <!-- Cuerpo -->
                <tbody class="divide-y divide-slate-100 bg-white">

                    <!-- Citas -->
                    <tr
                        v-for="appointment in appointments"
                        :key="appointment.id"
                        class="transition hover:bg-slate-50"
                    >

                        <!-- Paciente -->
                        <td class="whitespace-nowrap px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 font-semibold text-emerald-700"
                                >
                                    {{
                                        patientName(appointment)
                                            .charAt(0)
                                            .toUpperCase()
                                    }}
                                </div>

                                <div>

                                    <p class="font-semibold text-slate-800">
                                        {{ patientName(appointment) }}
                                    </p>

                                    <p
                                        v-if="appointment.patient?.dni"
                                        class="text-sm text-slate-500"
                                    >
                                        DNI: {{ appointment.patient.dni }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        <!-- Fecha -->
                        <td class="whitespace-nowrap px-6 py-5">

                            <p class="font-medium text-slate-700">
                                {{ formatDate(appointment.appointment_date) }}
                            </p>

                        </td>

                        <!-- Hora -->
                        <td class="whitespace-nowrap px-6 py-5">

                            <p class="font-medium text-slate-700">
                                {{ formatTime(appointment.appointment_time) }}
                            </p>

                        </td>

                        <!-- Tipo -->
                        <td class="px-6 py-5">

                            <span class="text-sm text-slate-600">
                                {{ typeLabel(appointment.type) }}
                            </span>

                        </td>

                        <!-- Estado -->
                        <td class="whitespace-nowrap px-6 py-5">

                            <span
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset"
                                :class="statusClass(appointment.status)"
                            >
                                {{ statusLabel(appointment.status) }}
                            </span>

                        </td>

                        <!-- Acciones -->
                        <td class="whitespace-nowrap px-6 py-5">

                            <div class="flex justify-end gap-2">

                                <!-- Ver -->
                                <Link
                                    :href="route(
                                        'appointments.show',
                                        appointment.id
                                    )"
                                    class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                                    title="Ver cita"
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
                                    title="Editar cita"
                                >
                                    Editar
                                </Link>

                                <!-- Eliminar -->
                                <button
                                    type="button"
                                    @click="deleteAppointment(appointment)"
                                    class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700"
                                    title="Eliminar cita"
                                >
                                    Eliminar
                                </button>

                            </div>

                        </td>

                    </tr>

                    <!-- Sin resultados -->
                    <tr v-if="appointments.length === 0">

                        <td
                            colspan="6"
                            class="px-6 py-16 text-center"
                        >

                            <div class="flex flex-col items-center">

                                <div
                                    class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-7 w-7 text-slate-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>

                                <h3 class="text-base font-semibold text-slate-800">
                                    No hay citas registradas
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Cuando registres una cita aparecerá aquí.
                                </p>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>
