<script setup>
defineProps({
    activities: {
        type: Array,
        default: () => [
            {
                patient: 'María López',
                action: 'Consulta nutricional realizada',
                date: 'Hoy - 09:00',
                icon: '🩺',
            },
            {
                patient: 'Carlos Pérez',
                action: 'Plan alimenticio creado',
                date: 'Ayer - 15:30',
                icon: '🥗',
            },
            {
                patient: 'Rosa García',
                action: 'Seguimiento completado',
                date: '25 Julio - 11:00',
                icon: '✅',
            },
        ],
    },
});
</script>


<template>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">


        <!-- Header -->
        <div class="mb-5">
            <h2 class="text-lg font-bold text-slate-800">
                Actividad reciente
            </h2>

            <p class="text-sm text-slate-500">
                Últimas consultas realizadas
            </p>
        </div>



        <!-- Activities -->
        <div class="space-y-4">


            <div
                v-for="activity in activities"
                :key="activity.patient + activity.date"
                class="flex items-start gap-4"
            >


                <!-- Icon -->
                <div
                    class="flex items-center justify-center
                           w-11 h-11 rounded-full
                           bg-emerald-50 text-xl"
                >
                    {{ activity.icon }}
                </div>



                <!-- Information -->
                <div class="flex-1">

                    <h3 class="font-semibold text-slate-800">
                        {{ activity.patient }}
                    </h3>


                    <p class="text-sm text-slate-600">
                        {{ activity.action }}
                    </p>


                    <span class="text-xs text-slate-400">
                        {{ activity.date }}
                    </span>

                </div>


            </div>


        </div>


    </div>

</template>
