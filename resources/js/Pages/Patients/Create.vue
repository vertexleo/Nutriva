<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';

import PatientForm from '@/Components/Patients/PatientForm.vue';
import ClinicalHistoryForm from '@/Components/Patients/ClinicalHistoryForm.vue';
import AnthropometricForm from '@/Components/Patients/AnthropometricForm.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';


/*
|--------------------------------------------------------------------------
| Formulario
|--------------------------------------------------------------------------
*/

const form = useForm({

    /*
    |--------------------------------------------------------------------------
    | Datos personales
    |--------------------------------------------------------------------------
    */

    first_name: '',
    last_name: '',
    dni: '',
    email: '',
    phone: '',
    birth_date: '',
    gender: '',
    occupation: '',
    address: '',
    active: true,


    /*
    |--------------------------------------------------------------------------
    | Historia clínica
    |--------------------------------------------------------------------------
    */

    clinical_history: {

        diseases: '',
        medications: '',
        allergies: '',

        goals: '',

        physical_activity: '',

        smoking: false,
        alcohol: false,

        sleep_hours: null,

        observations: '',
    },


    /*
    |--------------------------------------------------------------------------
    | Evaluación antropométrica inicial
    |--------------------------------------------------------------------------
    */

    anthropometric_record: {

        // Fecha actual automáticamente
        measured_at: new Date().toISOString().split('T')[0],

        weight: null,
        height: null,

        waist_circumference: null,

        body_fat: null,
        muscle_mass: null,

        visceral_fat: null,
        water_percentage: null,
        bone_mass: null,

        notes: '',
    },

});


/*
|--------------------------------------------------------------------------
| Guardar paciente
|--------------------------------------------------------------------------
*/

const submit = () => {

    form.post(route('patients.store'), {

        preserveScroll: true,

        onSuccess: () => {

            form.reset();

        },

    });

};

</script>


<template>

    <Head title="Nuevo paciente" />


    <AppLayout>

        <!-- ================================================================
             ENCABEZADO
        ================================================================= -->

        <div class="mb-8 flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Nuevo paciente
                </h1>

                <p class="mt-2 text-slate-500">
                    Registra un nuevo paciente y su evaluación inicial.
                </p>

            </div>


            <Link
                :href="route('patients.index')"
                class="rounded-xl border border-slate-300 px-5 py-3 text-slate-700 transition hover:bg-slate-100"
            >
                Volver
            </Link>

        </div>


        <!-- ================================================================
             FORMULARIO
        ================================================================= -->

        <form
            @submit.prevent="submit"
            class="space-y-8"
        >

            <!-- ============================================================
                 DATOS PERSONALES
            ============================================================= -->

            <PatientForm
                v-model="form"
            />


            <!-- ============================================================
                 HISTORIA CLÍNICA
            ============================================================= -->

            <ClinicalHistoryForm
                v-model="form.clinical_history"
            />


            <!-- ============================================================
                 EVALUACIÓN ANTROPOMÉTRICA
            ============================================================= -->

            <AnthropometricForm
                v-model="form.anthropometric_record"
            />


            <!-- ============================================================
                 BOTONES
            ============================================================= -->

            <div class="flex justify-end gap-4">

                <Link
                    :href="route('patients.index')"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-slate-700 transition hover:bg-slate-100"
                >
                    Cancelar
                </Link>


                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
                >

                    <span v-if="form.processing">
                        Guardando...
                    </span>

                    <span v-else>
                        Guardar paciente
                    </span>

                </button>

            </div>

        </form>

    </AppLayout>

</template>
