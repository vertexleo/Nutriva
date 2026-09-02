<script setup>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

import {
    MagnifyingGlassIcon,
    BellIcon,
    ChevronDownIcon,
    UserCircleIcon,
    ArrowRightOnRectangleIcon,
} from '@heroicons/vue/24/outline'

const showMenu = ref(false)

// Acceso seguro al estado global de Inertia
const page = usePage()
const user = computed(() => page.props.auth?.user)
const userInitial = computed(() => {
    return user.value?.name ? user.value.name.charAt(0).toUpperCase() : 'U'
})
</script>

<template>
    <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">

        <!-- Buscador -->
        <div class="w-full max-w-md">
            <div class="relative">
                <MagnifyingGlassIcon
                    class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                />

                <input
                    type="text"
                    placeholder="Buscar paciente..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-10 pr-4 outline-none transition focus:border-emerald-500 focus:bg-white"
                />
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex items-center gap-4">

            <!-- Notificaciones -->
            <button
                class="relative rounded-xl p-2 transition hover:bg-slate-100"
            >
                <BellIcon class="h-6 w-6 text-slate-600" />

                <span
                    class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full bg-red-500"
                ></span>
            </button>

            <!-- Usuario -->
            <div class="relative">

                <button
                    @click="showMenu = !showMenu"
                    class="flex items-center gap-3 rounded-xl px-2 py-2 transition hover:bg-slate-100"
                >
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500 font-semibold text-white"
                    >
                        {{ userInitial }}
                    </div>

                    <div class="hidden text-left md:block">
                        <p class="text-sm font-semibold text-slate-700">
                            {{ user?.name ?? 'Usuario' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Nutricionista
                        </p>
                    </div>

                    <ChevronDownIcon
                        class="h-4 w-4 text-slate-500"
                    />
                </button>

                <!-- Menú desplegable -->
                <div
                    v-if="showMenu"
                    class="absolute right-0 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
                >
                    <Link
                        :href="route('profile.edit')"
                        class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-50"
                    >
                        <UserCircleIcon class="h-5 w-5" />
                        Mi perfil
                    </Link>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm text-red-600 hover:bg-red-50"
                    >
                        <ArrowRightOnRectangleIcon class="h-5 w-5" />
                        Cerrar sesión
                    </Link>
                </div>

            </div>

        </div>

    </header>
</template>
