<script setup>

    import { CalendarRange, Users, FolderOpen, ChartColumn } from 'lucide-vue-next'

</script>

<template>

<section class="py-24">

        <div class="max-w-7xl mx-auto px-6">

            <h1 class="text-3xl font-bold text-center mb-12">

                Características principales

            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <div class="p-6 text-center">
                    <CalendarRange class="w-12 h-12 text-green-600 mx-auto my-2" />
                    <h3>Organiza tu tiempo</h3>
                    <p class="text-gray-600">Gestiona tus citas y pacientes de manera eficiente.</p>
                </div>

                <div class="p-6 text-center">
                    <FolderOpen class="w-12 h-12 text-red-600 mx-auto my-2" />
                    <h3>Todo en un solo lugar</h3>
                    <p class="text-gray-600">Sigue el progreso de tus pacientes y ajusta sus planes nutricionales.</p>
                </div>

                 <div class="p-6 text-center">
                    <Users class="w-12 h-12 text-blue-600 mx-auto my-2" />
                    <h3>Mejora la experiencia</h3>
                    <p class="text-gray-600">Mantén un registro detallado de la información de tus pacientes.</p>
                </div>

                <div class="p-6 text-center">
                    <ChartColumn class="w-12 h-12 text-purple-600 mx-auto my-2" />
                    <h3>Aumenta tu productividad</h3>
                    <p class="text-gray-600">Visualiza datos y estadísticas para mejorar tu práctica.</p>
                </div>

            </div>

    </div>

</section>

</template>
