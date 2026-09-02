<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppointmentForm from '@/Components/Appointments/AppointmentForm.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    patients: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    patient_id: '',
    appointment_date: '',
    appointment_time: '',
    type: 'initial',
    status: 'scheduled',
    notes: '',
});

const submit = () => {
    form.post(route('appointments.store'));
};
</script>

<template>

    <Head title="Nueva cita" />

    <AppLayout>

        <div class="mb-8 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Nueva cita
                </h1>

                <p class="mt-2 text-slate-500">
                    Registra una nueva cita para un paciente.
                </p>
            </div>

            <Link
                :href="route('appointments.index')"
                class="rounded-xl border border-slate-300 px-5 py-3 text-slate-700 transition hover:bg-slate-100"
            >
                Volver
            </Link>

        </div>


        <div class="max-w-4xl">

            <AppointmentForm
                :form="form"
                :patients="props.patients"
                submit-label="Guardar cita"
                @submit="submit"
            />

        </div>

    </AppLayout>

</template>
