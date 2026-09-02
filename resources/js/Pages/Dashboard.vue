<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";

import StatsCard from "@/Components/Dashboard/StatsCard.vue";
import QuickActions from "@/Components/Dashboard/QuickActions.vue";
import AppointmentCard from "@/Components/Dashboard/AppointmentCard.vue";
import FollowUpCard from "@/Components/Dashboard/FollowUpCard.vue";
import RecentActivity from "@/Components/Dashboard/RecentActivity.vue";
import MonthlyChart from "@/Components/Dashboard/MonthlyChart.vue";

import {
    UsersIcon,
    CalendarDaysIcon,
    ClipboardDocumentListIcon,
    UserPlusIcon,
} from "@heroicons/vue/24/outline";
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <!-- Bienvenida -->
        <section class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                ¡Buenos días, {{ $page.props.auth.user.name }}! 👋
            </h1>

            <p class="mt-2 text-slate-500">
                Hoy tienes
                <span class="font-semibold text-emerald-600">6 consultas</span>
                programadas y
                <span class="font-semibold text-orange-500"
                    >3 seguimientos</span
                >
                pendientes.
            </p>
        </section>

        <!-- Estadísticas -->
        <section class="mb-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <StatsCard
                title="Pacientes activos"
                value="184"
                change="+12 este mes"
                color="emerald"
                :icon="UsersIcon"
            />

            <StatsCard
                title="Consultas del mes"
                value="62"
                change="+8 respecto al mes anterior"
                color="blue"
                :icon="CalendarDaysIcon"
            />

            <StatsCard
                title="Seguimientos"
                value="18"
                change="5 pendientes para hoy"
                color="orange"
                :icon="ClipboardDocumentListIcon"
            />

            <StatsCard
                title="Pacientes nuevos"
                value="12"
                change="+3 esta semana"
                color="purple"
                :icon="UserPlusIcon"
            />
        </section>

        <!-- Agenda + Acciones -->
        <section class="mb-8 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <AppointmentCard />
            </div>

            <QuickActions />
        </section>

        <!-- Seguimientos + Actividad -->
        <section class="mb-8 grid gap-6 lg:grid-cols-2">
            <FollowUpCard />

            <RecentActivity />
        </section>

        <!-- Gráfico -->
        <section>
            <MonthlyChart />
        </section>
    </AppLayout>
</template>
