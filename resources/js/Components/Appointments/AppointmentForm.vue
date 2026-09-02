<script setup>
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },

    patients: {
        type: Array,
        default: () => [],
    },

    submitLabel: {
        type: String,
        default: 'Guardar cita',
    },
});

const emit = defineEmits(['submit']);

const submit = () => {
    emit('submit');
};
</script>

<template>
    <form
        @submit.prevent="submit"
        class="space-y-6"
    >

        <!-- Paciente -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-800">
                Información del paciente
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Selecciona el paciente para esta cita.
            </p>

            <div class="mt-5">

                <label
                    for="patient_id"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Paciente
                </label>

                <select
                    id="patient_id"
                    v-model="form.patient_id"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    :class="{
                        'border-red-500': form.errors?.patient_id
                    }"
                >

                    <option value="">
                        Seleccione un paciente
                    </option>

                    <option
                        v-for="patient in patients"
                        :key="patient.id"
                        :value="patient.id"
                    >
                        {{ patient.first_name }}
                        {{ patient.last_name }}
                        <span v-if="patient.dni">
                            - {{ patient.dni }}
                        </span>
                    </option>

                </select>

                <InputError
                    class="mt-2"
                    :message="form.errors?.patient_id"
                />

            </div>

        </div>


        <!-- Datos de la cita -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-800">
                Datos de la cita
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Programa la fecha, hora y tipo de consulta.
            </p>


            <div class="mt-5 grid gap-5 md:grid-cols-2">

                <!-- Fecha -->
                <div>

                    <label
                        for="appointment_date"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Fecha
                    </label>

                    <input
                        id="appointment_date"
                        v-model="form.appointment_date"
                        type="date"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        :class="{
                            'border-red-500': form.errors?.appointment_date
                        }"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors?.appointment_date"
                    />

                </div>


                <!-- Hora -->
                <div>

                    <label
                        for="appointment_time"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Hora
                    </label>

                    <input
                        id="appointment_time"
                        v-model="form.appointment_time"
                        type="time"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        :class="{
                            'border-red-500': form.errors?.appointment_time
                        }"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors?.appointment_time"
                    />

                </div>


                <!-- Tipo -->
                <div>

                    <label
                        for="type"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Tipo de consulta
                    </label>

                    <select
                        id="type"
                        v-model="form.type"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        :class="{
                            'border-red-500': form.errors?.type
                        }"
                    >

                        <option value="initial">
                            Consulta inicial
                        </option>

                        <option value="follow_up">
                            Control / Seguimiento
                        </option>

                        <option value="evaluation">
                            Evaluación nutricional
                        </option>

                        <option value="other">
                            Otro
                        </option>

                    </select>

                    <InputError
                        class="mt-2"
                        :message="form.errors?.type"
                    />

                </div>


                <!-- Estado -->
                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Estado
                    </label>

                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        :class="{
                            'border-red-500': form.errors?.status
                        }"
                    >

                        <option value="scheduled">
                            Programada
                        </option>

                        <option value="confirmed">
                            Confirmada
                        </option>

                        <option value="completed">
                            Completada
                        </option>

                        <option value="cancelled">
                            Cancelada
                        </option>

                        <option value="no_show">
                            No asistió
                        </option>

                    </select>

                    <InputError
                        class="mt-2"
                        :message="form.errors?.status"
                    />

                </div>

            </div>

        </div>


        <!-- Observaciones -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-800">
                Observaciones
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Agrega información adicional sobre la cita.
            </p>

            <div class="mt-5">

                <label
                    for="notes"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Observaciones
                </label>

                <textarea
                    id="notes"
                    v-model="form.notes"
                    rows="5"
                    placeholder="Escribe alguna observación..."
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    :class="{
                        'border-red-500': form.errors?.notes
                    }"
                ></textarea>

                <InputError
                    class="mt-2"
                    :message="form.errors?.notes"
                />

            </div>

        </div>


        <!-- Botones -->
        <div class="flex justify-end gap-4">

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
            >
                {{
                    form.processing
                        ? 'Guardando...'
                        : submitLabel
                }}
            </button>

        </div>

    </form>
</template>
