<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    actions: {
        type: Array,
        default: () => [
            {
                title: 'Nuevo paciente',
                description: 'Registrar paciente',
                icon: '➕',
                url: '#',
            },
            {
                title: 'Nueva cita',
                description: 'Agendar consulta',
                icon: '📅',
                url: '#',
            },
            {
                title: 'Crear plan alimenticio',
                description: 'Diseñar dieta',
                icon: '🥗',
                url: '#',
            },
            {
                title: 'Ver pacientes',
                description: 'Lista completa',
                icon: '📄',
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
                Acciones rápidas
            </h2>

            <p class="text-sm text-slate-500">
                Accesos frecuentes
            </p>
        </div>


        <!-- Actions -->
        <div class="space-y-3">

            <Link
                v-for="action in actions"
                :key="action.title"
                :href="action.url"
                class="flex items-center gap-4 p-4 rounded-xl
                       bg-slate-50 hover:bg-emerald-50
                       transition duration-200 group"
            >

                <!-- Icon -->
                <div
                    class="w-11 h-11 flex items-center justify-center
                           rounded-xl bg-white shadow-sm
                           text-xl group-hover:scale-110
                           transition"
                >
                    {{ action.icon }}
                </div>


                <!-- Text -->
                <div>
                    <h3 class="font-semibold text-slate-800">
                        {{ action.title }}
                    </h3>

                    <p class="text-sm text-slate-500">
                        {{ action.description }}
                    </p>
                </div>


                <!-- Arrow -->
                <div class="ml-auto text-slate-400 group-hover:text-emerald-600">
                    →
                </div>

            </Link>

        </div>

    </div>
</template>
