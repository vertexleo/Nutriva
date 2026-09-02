<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PatientForm from '@/Components/Patients/PatientForm.vue';
import ClinicalHistoryForm from '@/Components/Patients/ClinicalHistoryForm.vue';
import AnthropometricForm from '@/Components/Patients/AnthropometricForm.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    patient: {
        type: Object,
        required: true,
    },
});

const patient = props.patient;

/*
|--------------------------------------------------------------------------
| Formulario
|--------------------------------------------------------------------------
*/

const form = useForm({
    // Datos personales
    first_name: patient.first_name ?? '',
    last_name: patient.last_name ?? '',
    dni: patient.dni ?? '',
    email: patient.email ?? '',
    phone: patient.phone ?? '',
    birth_date: patient.birth_date
        ? patient.birth_date.substring(0, 10)
        : '',
    gender: patient.gender ?? '',
    occupation: patient.occupation ?? '',
    address: patient.address ?? '',
    active: patient.active ?? true,

    // Historia clínica
    clinical_history: {
        diseases: patient.clinical_history?.diseases ?? '',
        medications: patient.clinical_history?.medications ?? '',
        allergies: patient.clinical_history?.allergies ?? '',
        goals: patient.clinical_history?.goals ?? '',
        physical_activity:
            patient.clinical_history?.physical_activity ?? '',
        smoking: patient.clinical_history?.smoking ?? false,
        alcohol: patient.clinical_history?.alcohol ?? false,
        sleep_hours:
            patient.clinical_history?.sleep_hours ?? null,
        observations:
            patient.clinical_history?.observations ?? '',
    },

    // Evaluación antropométrica
    anthropometric_record: {
        measured_at:
            patient.anthropometric_records?.[0]?.measured_at ?? '',

        weight:
            patient.anthropometric_records?.[0]?.weight ?? null,

        height:
            patient.anthropometric_records?.[0]?.height ?? null,

        waist_circumference:
            patient.anthropometric_records?.[0]?.waist_circumference ?? null,

        body_fat:
            patient.anthropometric_records?.[0]?.body_fat ?? null,

        muscle_mass:
            patient.anthropometric_records?.[0]?.muscle_mass ?? null,

        visceral_fat:
            patient.anthropometric_records?.[0]?.visceral_fat ?? null,

        water_percentage:
            patient.anthropometric_records?.[0]?.water_percentage ?? null,

        bone_mass:
            patient.anthropometric_records?.[0]?.bone_mass ?? null,

        notes:
            patient.anthropometric_records?.[0]?.notes ?? '',
    },
});

/*
|--------------------------------------------------------------------------
| Actualizar paciente
|--------------------------------------------------------------------------
*/

const submit = () => {
    form.put(route('patients.update', patient.id));
};
</script>

<template>
    <Head title="Editar paciente" />

    <AppLayout>

        <!-- Encabezado -->
        <div class="mb-8 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Editar paciente
                </h1>

                <p class="mt-2 text-slate-500">
                    Actualiza la información del paciente.
                </p>
            </div>

            <Link
                :href="route('patients.show', patient.id)"
                class="rounded-xl border border-slate-300 px-5 py-3 text-slate-700 transition hover:bg-slate-100"
            >
                Volver
            </Link>

        </div>

        <!-- Formulario -->
        <form
            @submit.prevent="submit"
            class="space-y-8"
        >

            <!-- Datos personales -->
            <PatientForm
                v-model="form"
            />

            <!-- Historia clínica -->
            <ClinicalHistoryForm
                v-model="form.clinical_history"
            />

            <!-- Evaluación antropométrica -->
            <AnthropometricForm
                v-model="form.anthropometric_record"
            />

            <!-- Botones -->
            <div class="flex justify-end gap-4">

                <Link
                    :href="route('patients.show', patient.id)"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-slate-700 transition hover:bg-slate-100"
                >
                    Cancelar
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white transition hover:bg-emerald-700 disabled:opacity-50"
                >
                    {{
                        form.processing
                            ? 'Guardando...'
                            : 'Guardar cambios'
                    }}
                </button>

            </div>

        </form>

    </AppLayout>
</template>
