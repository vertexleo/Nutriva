<script setup>
import {
    CalendarDaysIcon,
    ClockIcon,
    ChevronRightIcon,
} from "@heroicons/vue/24/outline";

const appointments = [
    {
        time: "09:00",
        patient: "María Gómez",
        type: "Primera consulta",
        status: "Confirmada",
        color: "emerald",
    },
    {
        time: "10:00",
        patient: "Carlos Ruiz",
        type: "Seguimiento",
        status: "En 30 minutos",
        color: "blue",
    },
    {
        time: "11:30",
        patient: "Andrea López",
        type: "Control mensual",
        status: "Pendiente",
        color: "orange",
    },
];
</script>

<template>
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Header -->

        <div
            class="flex items-center justify-between border-b border-slate-100 p-6"
        >
            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50"
                >
                    <CalendarDaysIcon
                        class="h-5 w-5 text-emerald-600"
                    />
                </div>

                <div>

                    <h2
                        class="text-lg font-semibold text-slate-800"
                    >
                        Agenda de Hoy
                    </h2>

                    <p class="text-sm text-slate-500">
                        3 consultas programadas
                    </p>

                </div>

            </div>

            <button
                class="text-sm font-medium text-emerald-600 hover:text-emerald-700"
            >
                Ver agenda
            </button>

        </div>

        <!-- Lista -->

        <div class="divide-y divide-slate-100">

            <div
                v-for="appointment in appointments"
                :key="appointment.time"
                class="flex items-center justify-between p-5 transition hover:bg-slate-50"
            >

                <div class="flex items-center gap-4">

                    <!-- Hora -->

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100"
                    >
                        <ClockIcon
                            class="h-5 w-5 text-slate-500"
                        />
                    </div>

                    <!-- Información -->

                    <div>

                        <div
                            class="flex items-center gap-3"
                        >

                            <span
                                class="font-semibold text-slate-800"
                            >
                                {{ appointment.time }}
                            </span>

                            <span
                                class="text-slate-300"
                            >
                                |
                            </span>

                            <span
                                class="font-medium text-slate-700"
                            >
                                {{ appointment.patient }}
                            </span>

                        </div>

                        <div
                            class="mt-1 flex items-center gap-2 text-sm"
                        >

                            <span class="text-slate-500">
                                {{ appointment.type }}
                            </span>

                            <span
                                class="text-slate-300"
                            >
                                •
                            </span>

                            <span
                                :class="{
                                    'text-emerald-600': appointment.color === 'emerald',
                                    'text-blue-600': appointment.color === 'blue',
                                    'text-orange-500': appointment.color === 'orange',
                                }"
                                class="font-medium"
                            >
                                {{ appointment.status }}
                            </span>

                        </div>

                    </div>

                </div>

                <!-- Flecha -->

                <ChevronRightIcon
                    class="h-5 w-5 text-slate-400"
                />

            </div>

        </div>

    </div>
</template>
