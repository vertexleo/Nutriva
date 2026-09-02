FilesTab.vue
<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({

    patient: {
        type: Object,
        required: true,
    },

})
</script>

<template>

<div class="space-y-6">

    <!-- Encabezado -->

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-xl font-semibold text-slate-800">
                Archivos
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Documentos e imágenes asociados al paciente.
            </p>

        </div>

        <Link
            href="#"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
        >

            Subir archivo

        </Link>

    </div>

    <!-- Sin archivos -->

    <div
        v-if="!patient.files || patient.files.length === 0"
        class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center"
    >

        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-200 text-3xl"
        >
            📁
        </div>

        <h3 class="mt-5 text-lg font-semibold text-slate-700">
            No hay archivos registrados
        </h3>

        <p class="mt-2 text-slate-500">
            Sube documentos, exámenes, fotografías o archivos relacionados con el paciente.
        </p>

    </div>

    <!-- Lista -->

    <div
        v-else
        class="space-y-4"
    >

        <div
            v-for="file in patient.files"
            :key="file.id"
            class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 transition hover:shadow-md"
        >

            <div class="flex items-center gap-4">

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-100 text-2xl"
                >

                    📄

                </div>

                <div>

                    <h3 class="font-semibold text-slate-800">

                        {{ file.name }}

                    </h3>

                    <p class="mt-1 text-sm text-slate-500">

                        {{ file.type }}

                        •

                        {{ file.size }}

                        •

                        {{ file.created_at }}

                    </p>

                </div>

            </div>

            <div class="flex gap-3">

                <Link
                    href="#"
                    class="rounded-lg border border-emerald-600 px-4 py-2 text-sm font-medium text-emerald-600 hover:bg-emerald-50"
                >

                    Ver

                </Link>

                <Link
                    href="#"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                >

                    Descargar

                </Link>

                <Link
                    href="#"
                    class="rounded-lg border border-red-300 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                >

                    Eliminar

                </Link>

            </div>

        </div>

    </div>

</div>

</template>
