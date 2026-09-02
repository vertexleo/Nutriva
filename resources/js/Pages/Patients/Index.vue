<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PatientTable from '@/Components/Patients/PatientTable.vue'

defineProps({
    patients: {
        type: Array,
        required: true
    }
})

// Handlers de navegación con Inertia Router
const createPatient = () => {
    router.visit(route('patients.create'))
}

const showPatient = (patientId) => {
    router.visit(route('patients.show', patientId))
}

const editPatient = (patientId) => {
    router.visit(route('patients.edit', patientId))
}
</script>

<template>
    <Head title="Pacientes" />

    <AppLayout>
        <div class="space-y-6">
            <!-- Encabezado -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">
                        Pacientes
                    </h1>
                    <p class="mt-2 text-slate-500">
                        Administra la información de todos tus pacientes.
                    </p>
                </div>
            </div>

            <!-- Tabla de Pacientes -->
            <PatientTable
                :patients="patients"
                @create="createPatient"
                @show="showPatient"
                @edit="editPatient"
            />
        </div>
    </AppLayout>
</template>
