<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppointmentForm from '@/Components/Appointments/AppointmentForm.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    appointment: {
        type: Object,
        required: true,
    },

    patients: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    patient_id: props.appointment.patient_id ?? '',

    // Extraer exactamente 'YYYY-MM-DD' para ser compatible con <input type="date">
    appointment_date: props.appointment.appointment_date
        ? props.appointment.appointment_date.substring(0, 10)
        : '',

    appointment_time: props.appointment.appointment_time
        ? props.appointment.appointment_time.substring(0, 5)
        : '',
    type: props.appointment.type ?? 'initial',
    status: props.appointment.status ?? 'scheduled',
    notes: props.appointment.notes ?? '',
});

const submit = () => {
    form.put(
        route(
            'appointments.update',
            props.appointment.id
        )
    );
};
</script>

<template>
    <Head title="Editar cita" />

    <AppLayout>

        <!-- Encabezado -->
        <div class="mb-8 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Editar cita
                </h1>

                <p class="mt-2 text-slate-500">
                    Actualiza la información de la cita.
                </p>
            </div>

            <Link
                :href="route('appointments.index')"
                class="rounded-xl border border-slate-300 px-5 py-3 text-slate-700 transition hover:bg-slate-100"
            >
                Volver
            </Link>

        </div>

        <!-- Formulario -->
        <div class="max-w-4xl">

            <AppointmentForm
                :form="form"
                :patients="patients"
                submit-label="Actualizar cita"
                @submit="submit"
            />

        </div>

    </AppLayout>
</template>
