<script setup>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';

import { Line } from 'vue-chartjs';


ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);



defineProps({

    data: {
        type: Object,
        default: () => ({
            labels: [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Ago',
                'Sep',
                'Oct',
                'Nov',
                'Dic',
            ],

            datasets: [
                {
                    label: 'Consultas',
                    data: [
                        12,
                        19,
                        15,
                        25,
                        22,
                        30,
                        28,
                        35,
                        32,
                        40,
                        38,
                        45,
                    ],

                    tension: 0.4,
                    borderWidth: 3,

                    pointRadius: 5,
                },
            ],
        }),
    },

});


const options = {

    responsive: true,

    maintainAspectRatio: false,


    plugins: {

        legend: {
            display: true,
        },

        tooltip: {
            enabled: true,
        },

    },


    scales: {

        y: {

            beginAtZero: true,

            ticks: {
                precision: 0,
            },

        },

    },

};

</script>



<template>

    <div
        class="bg-white rounded-2xl shadow-sm
               border border-slate-100 p-6"
    >


        <!-- Header -->

        <div class="mb-5">

            <h2 class="text-lg font-bold text-slate-800">
                Consultas por mes
            </h2>


            <p class="text-sm text-slate-500">
                Evolución de consultas realizadas
            </p>

        </div>



        <!-- Chart -->

        <div class="h-80">

            <Line
                :data="data"
                :options="options"
            />

        </div>


    </div>

</template>
