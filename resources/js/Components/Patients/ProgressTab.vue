<script setup>
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

    <div>

        <h2 class="text-xl font-semibold text-slate-800">
            Evolución del paciente
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Seguimiento de las evaluaciones antropométricas registradas.
        </p>

    </div>

    <!-- Resumen -->

    <div
        class="grid gap-6 md:grid-cols-4"
    >

        <div class="rounded-xl border bg-white p-5">

            <p class="text-sm text-slate-500">
                Evaluaciones
            </p>

            <h3 class="mt-2 text-3xl font-bold">

                {{ patient.anthropometric_records?.length ?? 0 }}

            </h3>

        </div>

        <div class="rounded-xl border bg-white p-5">

            <p class="text-sm text-slate-500">
                Peso actual
            </p>

            <h3 class="mt-2 text-3xl font-bold text-emerald-600">

                {{ patient.last_record?.weight ?? '--' }}

                kg

            </h3>

        </div>

        <div class="rounded-xl border bg-white p-5">

            <p class="text-sm text-slate-500">
                IMC actual
            </p>

            <h3 class="mt-2 text-3xl font-bold">

                {{ patient.last_record?.bmi ?? '--' }}

            </h3>

        </div>

        <div class="rounded-xl border bg-white p-5">

            <p class="text-sm text-slate-500">
                Grasa corporal
            </p>

            <h3 class="mt-2 text-3xl font-bold">

                {{ patient.last_record?.body_fat ?? '--' }}

                %

            </h3>

        </div>

    </div>

    <!-- Gráfico -->

    <div
        class="rounded-2xl border border-slate-200 bg-white p-8"
    >

        <h3
            class="mb-6 text-lg font-semibold"
        >
            Evolución del peso
        </h3>

        <div
            class="flex h-72 items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50"
        >

            <p class="text-slate-400">

                Aquí se mostrará el gráfico de evolución.

            </p>

        </div>

    </div>

    <!-- Historial -->

    <div
        class="rounded-2xl border border-slate-200 bg-white"
    >

        <div
            class="border-b px-6 py-4"
        >

            <h3 class="font-semibold text-slate-800">

                Historial de evaluaciones

            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs uppercase text-slate-500">
                            Fecha
                        </th>

                        <th class="px-6 py-3 text-left text-xs uppercase text-slate-500">
                            Peso
                        </th>

                        <th class="px-6 py-3 text-left text-xs uppercase text-slate-500">
                            IMC
                        </th>

                        <th class="px-6 py-3 text-left text-xs uppercase text-slate-500">
                            Grasa %
                        </th>

                        <th class="px-6 py-3 text-left text-xs uppercase text-slate-500">
                            Músculo %
                        </th>

                        <th class="px-6 py-3 text-left text-xs uppercase text-slate-500">
                            Cintura
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr
                        v-if="!patient.anthropometric_records || patient.anthropometric_records.length === 0"
                    >

                        <td
                            colspan="6"
                            class="py-10 text-center text-slate-500"
                        >

                            No existen evaluaciones registradas.

                        </td>

                    </tr>

                    <tr
                        v-for="record in patient.anthropometric_records"
                        :key="record.id"
                        class="border-t"
                    >

                        <td class="px-6 py-4">

                            {{ record.measured_at }}

                        </td>

                        <td class="px-6 py-4">

                            {{ record.weight }} kg

                        </td>

                        <td class="px-6 py-4">

                            {{ record.bmi }}

                        </td>

                        <td class="px-6 py-4">

                            {{ record.body_fat }} %

                        </td>

                        <td class="px-6 py-4">

                            {{ record.muscle_mass }} %

                        </td>

                        <td class="px-6 py-4">

                            {{ record.waist_circumference }} cm

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</template>
