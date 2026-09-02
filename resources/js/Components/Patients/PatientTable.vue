<script setup>
import { computed, ref } from 'vue'
import {
    PencilSquareIcon,
    EyeIcon,
    MagnifyingGlassIcon,
    UserPlusIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
    patients: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits([
    'create',
    'edit',
    'show',
])

const search = ref('')

const filteredPatients = computed(() => {

    if (!search.value) {
        return props.patients
    }

    return props.patients.filter(patient => {

        const text = search.value.toLowerCase()

        return (
            patient.full_name.toLowerCase().includes(text) ||
            patient.dni.includes(text)
        )

    })

})
</script>

<template>

<div class="rounded-2xl bg-white shadow-sm border border-slate-200">

    <!-- Header -->

    <div
        class="flex items-center justify-between border-b border-slate-100 p-6"
    >

        <div>

            <h2
                class="text-xl font-semibold text-slate-800"
            >
                Pacientes
            </h2>

            <p
                class="text-sm text-slate-500"
            >
                Gestiona todos tus pacientes.
            </p>

        </div>

        <button
            @click="$emit('create')"
            class="flex items-center rounded-xl bg-emerald-500 px-5 py-3 text-white transition hover:bg-emerald-600"
        >

            <UserPlusIcon
                class="mr-2 h-5 w-5"
            />

            Nuevo paciente

        </button>

    </div>

    <!-- Search -->

    <div
        class="border-b border-slate-100 p-5"
    >

        <div
            class="relative max-w-md"
        >

            <MagnifyingGlassIcon
                class="absolute left-3 top-3 h-5 w-5 text-slate-400"
            />

            <input

                v-model="search"

                type="text"

                placeholder="Buscar por nombre o DNI..."

                class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 focus:border-emerald-500 focus:outline-none"

            >

        </div>

    </div>

    <!-- Table -->

    <div class="overflow-x-auto">

        <table
            class="w-full"
        >

            <thead
                class="bg-slate-50"
            >

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                        Paciente
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                        Edad
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                        Teléfono
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                        Estado
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-500">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody>

                <tr

                    v-for="patient in filteredPatients"

                    :key="patient.id"

                    class="border-t border-slate-100 hover:bg-slate-50"

                >

                    <td class="px-6 py-4">

                        <div
                            class="font-semibold text-slate-700"
                        >
                            {{ patient.full_name }}
                        </div>

                        <div
                            class="text-sm text-slate-500"
                        >
                            DNI: {{ patient.dni }}
                        </div>

                    </td>

                    <td class="px-6 py-4">

                        {{ patient.age }} años

                    </td>

                    <td class="px-6 py-4">

                        {{ patient.phone }}

                    </td>

                    <td class="px-6 py-4">

                        <span

                            class="rounded-full px-3 py-1 text-xs font-semibold"

                            :class="patient.active
                                ? 'bg-emerald-100 text-emerald-700'
                                : 'bg-red-100 text-red-700'
                            "

                        >

                            {{ patient.active ? 'Activo' : 'Inactivo' }}

                        </span>

                    </td>

                    <td
                        class="px-6 py-4"
                    >

                        <div
                            class="flex justify-center gap-2"
                        >

                            <button

                                @click="$emit('show', patient)"

                                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100"

                            >

                                <EyeIcon class="h-5 w-5"/>

                            </button>

                            <button

                                @click="$emit('edit', patient)"

                                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100"

                            >

                                <PencilSquareIcon class="h-5 w-5"/>

                            </button>

                        </div>

                    </td>

                </tr>

                <tr
                    v-if="filteredPatients.length === 0"
                >

                    <td
                        colspan="5"
                        class="py-10 text-center text-slate-400"
                    >

                        No se encontraron pacientes.

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

</template>
