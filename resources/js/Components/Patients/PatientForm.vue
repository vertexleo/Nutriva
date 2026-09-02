<script setup>
const form = defineModel({
    type: Object,
    required: true,
})
</script>

<template>

<div class="rounded-2xl bg-white border border-slate-200 p-8">

    <div class="mb-8">

        <h2 class="text-2xl font-semibold text-slate-800">
            Datos personales
        </h2>

        <p class="mt-1 text-slate-500">
            Información básica del paciente.
        </p>

    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Nombres -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Nombres
            </label>

            <input
                v-model="form.first_name"
                type="text"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                placeholder="Juan"
            >

        </div>

        <!-- Apellidos -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Apellidos
            </label>

            <input
                v-model="form.last_name"
                type="text"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
                placeholder="Pérez"
            >

        </div>

        <!-- DNI -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                DNI
            </label>

            <input
                v-model="form.dni"
                type="text"
                maxlength="8"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
            >

        </div>

        <!-- Fecha -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Fecha de nacimiento
            </label>

            <input
                v-model="form.birth_date"
                type="date"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
            >

        </div>

        <!-- Sexo -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Sexo
            </label>

            <select
                v-model="form.gender"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
            >

                <option value="">
                    Seleccione...
                </option>

                <option value="male">
                    Masculino
                </option>

                <option value="female">
                    Femenino
                </option>

            </select>

        </div>

        <!-- Teléfono -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Teléfono
            </label>

            <input
                v-model="form.phone"
                type="text"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
            >

        </div>

        <!-- Correo -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Correo electrónico
            </label>

            <input
                v-model="form.email"
                type="email"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
            >

        </div>

        <!-- Ocupación -->

        <div>

            <label class="mb-2 block text-sm font-medium text-slate-700">
                Ocupación
            </label>

            <input
                v-model="form.occupation"
                type="text"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
            >

        </div>

    </div>

    <!-- Dirección -->

    <div class="mt-6">

        <label class="mb-2 block text-sm font-medium text-slate-700">
            Dirección
        </label>

        <textarea
            v-model="form.address"
            rows="3"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:outline-none"
        />

    </div>

</div>

</template>
