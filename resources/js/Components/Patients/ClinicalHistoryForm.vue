<script setup>
const form = defineModel({
    type: Object,
    required: true,
})
</script>

<template>

<div class="rounded-2xl border border-slate-200 bg-white p-8">

    <!-- Encabezado -->

    <div class="mb-8">

        <h2 class="text-2xl font-semibold text-slate-800">
            Historia clínica
        </h2>

        <p class="mt-1 text-slate-500">
            Información médica y hábitos del paciente.
        </p>

    </div>

    <!-- Antecedentes -->

    <div class="mb-8">

        <h3 class="mb-4 text-lg font-semibold text-slate-700">
            Antecedentes
        </h3>

        <div class="space-y-5">

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Enfermedades
                </label>

                <textarea
                    v-model="form.diseases"
                    rows="3"
                    placeholder="Diabetes, hipertensión, gastritis..."
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                />

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Medicamentos
                </label>

                <textarea
                    v-model="form.medications"
                    rows="3"
                    placeholder="Medicamentos de uso frecuente..."
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                />

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Alergias
                </label>

                <textarea
                    v-model="form.allergies"
                    rows="3"
                    placeholder="Alimentos, medicamentos, etc."
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                />

            </div>

        </div>

    </div>

    <!-- Hábitos -->

    <div class="mb-8">

        <h3 class="mb-4 text-lg font-semibold text-slate-700">
            Hábitos
        </h3>

        <div class="grid gap-6 md:grid-cols-2">

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Actividad física
                </label>

                <select
                    v-model="form.physical_activity"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >
                    <option value="">
                        Seleccione...
                    </option>

                    <option value="sedentary">
                        Sedentario
                    </option>

                    <option value="light">
                        Ligera
                    </option>

                    <option value="moderate">
                        Moderada
                    </option>

                    <option value="intense">
                        Intensa
                    </option>

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Horas de sueño
                </label>

                <input
                    v-model="form.sleep_hours"
                    type="number"
                    min="0"
                    max="24"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    ¿Fuma?
                </label>

                <select
                    v-model="form.smoking"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

                    <option :value="false">
                        No
                    </option>

                    <option :value="true">
                        Sí
                    </option>

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    ¿Consume alcohol?
                </label>

                <select
                    v-model="form.alcohol"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

                    <option :value="false">
                        No
                    </option>

                    <option :value="true">
                        Sí
                    </option>

                </select>

            </div>

        </div>

    </div>

    <!-- Objetivo -->

    <div class="mb-8">

        <h3 class="mb-4 text-lg font-semibold text-slate-700">
            Objetivo del tratamiento
        </h3>

        <textarea
            v-model="form.goals"
            rows="4"
            placeholder="Bajar de peso, aumentar masa muscular, controlar glucosa..."
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
        />

    </div>

    <!-- Observaciones -->

    <div>

        <h3 class="mb-4 text-lg font-semibold text-slate-700">
            Observaciones
        </h3>

        <textarea
            v-model="form.observations"
            rows="5"
            placeholder="Observaciones adicionales del nutricionista..."
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
        />

    </div>

</div>

</template>
