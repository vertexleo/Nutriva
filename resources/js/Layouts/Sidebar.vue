<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

import {
    HomeIcon,
    UsersIcon,
    CalendarDaysIcon,
    ClipboardDocumentListIcon,
    CubeIcon,
    ChartBarIcon,
    Cog6ToothIcon,
} from "@heroicons/vue/24/outline";

// Acceso seguro al estado de Inertia
const page = usePage();
const user = computed(() => page.props.auth?.user);
const userInitial = computed(() => {
    return user.value?.name ? user.value.name.charAt(0).toUpperCase() : 'U';
});

const menu = [
    {
        title: "Principal",
        items: [
            {
                name: "Dashboard",
                route: "dashboard",
                icon: HomeIcon,
            },
        ],
    },
    {
        title: "Gestión",
        items: [
            {
                name: "Pacientes",
                route: "patients.index",
                icon: UsersIcon,
            },
            {
                name: "Agenda",
                route: "appointments.index",
                icon: CalendarDaysIcon,
            },
            {
                name: "Planes",
                route: "diets.index",
                icon: ClipboardDocumentListIcon,
            },
            {
                name: "Alimentos",
                route: "foods.index",
                icon: CubeIcon,
            },
        ],
    },
    {
        title: "Análisis",
        items: [
            {
                name: "Reportes",
                route: "reports.index",
                icon: ChartBarIcon,
            },
        ],
    },
    {
        title: "Sistema",
        items: [
            {
                name: "Configuración",
                route: "settings.index",
                icon: Cog6ToothIcon,
            },
        ],
    },
];
</script>

<template>
    <aside
        class="flex h-screen w-72 flex-col border-r border-slate-200 bg-white"
    >
        <!-- Logo -->
        <div class="border-b border-slate-100 p-6">
            <h1 class="text-2xl font-bold text-emerald-600">Nutriva</h1>
            <p class="mt-1 text-sm text-slate-500">Nutrición Inteligente</p>
        </div>

        <!-- Menú -->
        <nav class="flex-1 overflow-y-auto px-4 py-6">
            <div v-for="section in menu" :key="section.title" class="mb-8">
                <h3
                    class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                >
                    {{ section.title }}
                </h3>

                <Link
                    v-for="item in section.items"
                    :key="item.name"
                    :href="route(item.route)"
                    class="mb-1 flex items-center rounded-xl px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="
                        route().current(item.route)
                            ? 'bg-emerald-50 text-emerald-600'
                            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                    "
                >
                    <component :is="item.icon" class="mr-3 h-5 w-5" />
                    {{ item.name }}
                </Link>
            </div>
        </nav>

        <!-- Usuario -->
        <div class="border-t border-slate-200 p-5">
            <div class="flex items-center">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-500 font-semibold text-white"
                >
                    {{ userInitial }}
                </div>

                <div class="ml-3">
                    <p class="font-semibold text-slate-700">
                        {{ user?.name ?? 'Usuario' }}
                    </p>

                    <p class="text-xs text-slate-500">Nutricionista</p>
                </div>
            </div>
        </div>
    </aside>
</template>
