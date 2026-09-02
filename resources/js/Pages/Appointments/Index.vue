<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppointmentTable from '@/Components/Appointments/AppointmentTable.vue';
import AppointmentCard from '@/Components/Appointments/AppointmentCard.vue';

import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    appointments: {
        type: Array,
        default: () => [],
    },
});

const deleteAppointment = (appointment) => {
    if (
        !confirm(
            '¿Estás seguro de que deseas eliminar esta cita?'
        )
    ) {
        return;
    }

    router.delete(
        route('appointments.destroy', appointment.id)
    );
};
</script>

<template>
    <Head title="Agenda" />

    <AppLayout>

        <!-- Encabezado -->
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Agenda
                </h1>

                <p class="mt-2 text-slate-500">
                    Gestiona tus citas y consultas nutricionales.
                </p>
            </div>

            <Link
                :href="route('appointments.create')"
                class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white transition hover:bg-emerald-700"
            >
                + Nueva cita
            </Link>

        </div>

        <!-- Vista escritorio -->
        <div class="hidden md:block">

            <AppointmentTable
                :appointments="appointments"
                @delete="deleteAppointment"
            />

        </div>

        <!-- Vista móvil -->
        <div class="space-y-4 md:hidden">

            <AppointmentCard
                v-for="appointment in appointments"
                :key="appointment.id"
                :appointment="appointment"
                @delete="deleteAppointment"
            />

            <div
                v-if="appointments.length === 0"
                class="rounded-2xl border border-slate-200 bg-white p-8 text-center"
            >
                <p class="font-semibold text-slate-700">
                    No hay citas registradas
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Registra tu primera cita para comenzar.
                </p>
            </div>

        </div>

    </AppLayout>
</template>
