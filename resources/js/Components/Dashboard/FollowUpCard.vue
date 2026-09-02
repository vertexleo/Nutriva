<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    followUps: {
        type: Array,
        default: () => [
            {
                patient: 'María López',
                lastControl: 'Hace 20 días',
                status: 'Pendiente',
                url: '#',
            },
            {
                patient: 'Carlos Pérez',
                lastControl: 'Hace 15 días',
                status: 'Pendiente',
                url: '#',
            },
            {
                patient: 'Rosa García',
                lastControl: 'Hace 10 días',
                status: 'Revisar',
                url: '#',
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
                Seguimientos pendientes
            </h2>

            <p class="text-sm text-slate-500">
                Pacientes sin control reciente
            </p>

        </div>



        <!-- Follow ups -->
        <div class="space-y-4">


            <div
                v-for="followUp in followUps"
                :key="followUp.patient"
                class="flex items-center gap-4
                       p-3 rounded-xl
                       hover:bg-slate-50 transition"
            >


                <!-- Warning Icon -->
                <div
                    class="flex items-center justify-center
                           w-11 h-11 rounded-full
                           bg-amber-50 text-xl"
                >
                    ⚠️
                </div>



                <!-- Patient Info -->
                <div class="flex-1">


                    <h3 class="font-semibold text-slate-800">
                        {{ followUp.patient }}
                    </h3>


                    <p class="text-sm text-slate-500">
                        Último control:
                        {{ followUp.lastControl }}
                    </p>


                    <span
                        class="inline-flex mt-1 px-2 py-1
                               rounded-full text-xs
                               bg-amber-100 text-amber-700"
                    >
                        {{ followUp.status }}
                    </span>


                </div>



                <!-- Action -->
                <Link
                    :href="followUp.url"
                    class="text-sm font-medium
                           text-emerald-600
                           hover:text-emerald-700"
                >
                    Ver →
                </Link>


            </div>


        </div>


    </div>

</template>
