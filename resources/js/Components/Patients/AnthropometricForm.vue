<script setup>
import { computed } from 'vue'

const form = defineModel({
    type: Object,
    required: true,
})

const bmi = computed(() => {

    if (!form.value.weight || !form.value.height) {
        return ''
    }

    const height = Number(form.value.height)
    const weight = Number(form.value.weight)

    if (height <= 0) {
        return ''
    }

    return (weight / (height * height)).toFixed(2)

})
</script>

<template>

<div class="rounded-2xl border border-slate-200 bg-white p-8">

    <!-- Encabezado -->

    <div class="mb-8">

        <h2 class="text-2xl font-semibold text-slate-800">
            Evaluación antropométrica
        </h2>

        <p class="mt-1 text-slate-500">
            Registro de medidas corporales del paciente.
        </p>

    </div>

    <!-- Medidas básicas -->

    <div class="mb-8">

        <h3 class="mb-4 text-lg font-semibold text-slate-700">

            Medidas básicas

        </h3>

        <div class="grid gap-6 md:grid-cols-3">

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Peso (kg)

                </label>

                <input
                    v-model="form.weight"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Talla (m)

                </label>

                <input
                    v-model="form.height"
                    type="number"
                    step="0.01"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    IMC

                </label>

                <input
                    :value="bmi"
                    readonly
                    class="w-full rounded-xl border bg-slate-100 px-4 py-3 font-semibold text-emerald-600"
                >

            </div>

        </div>

    </div>

    <!-- Composición corporal -->

    <div class="mb-8">

        <h3 class="mb-4 text-lg font-semibold text-slate-700">

            Composición corporal

        </h3>

        <div class="grid gap-6 md:grid-cols-2">

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Grasa corporal (%)

                </label>

                <input
                    v-model="form.body_fat"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Masa muscular (kg)

                </label>

                <input
                    v-model="form.muscle_mass"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Grasa visceral

                </label>

                <input
                    v-model="form.visceral_fat"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Agua corporal (%)

                </label>

                <input
                    v-model="form.water_percentage"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Masa ósea (kg)

                </label>

                <input
                    v-model="form.bone_mass"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

        </div>

    </div>

    <!-- Medidas adicionales -->

    <div class="mb-8">

        <h3 class="mb-4 text-lg font-semibold text-slate-700">

            Medidas complementarias

        </h3>

        <div class="grid gap-6 md:grid-cols-2">

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">

                    Circunferencia abdominal (cm)

                </label>

                <input
                    v-model="form.waist_circumference"
                    type="number"
                    step="0.1"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                >

            </div>

        </div>

    </div>

    <!-- Observaciones -->

    <div>

        <label class="mb-2 block text-sm font-medium text-slate-700">

            Observaciones

        </label>

        <textarea
            v-model="form.notes"
            rows="4"
            placeholder="Observaciones de la evaluación..."
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
        />

    </div>

</div>

</template>
