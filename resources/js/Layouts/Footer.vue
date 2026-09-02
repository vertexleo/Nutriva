<script setup>
const year = new Date().getFullYear()
</script>

<template>
    <footer
        class="flex items-center justify-between border-t border-slate-200 bg-white px-6 py-4 text-sm text-slate-500"
    >
        <!-- Lado izquierdo -->
        <div>
            © {{ year }} <span class="font-semibold text-slate-700">Nutriva</span>.
            Todos los derechos reservados.
        </div>

        <!-- Lado derecho -->
        <div class="flex items-center gap-6">
            <span>Versión 1.0.0</span>

            <span
                class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700"
            >
                Sistema operativo
            </span>
        </div>
    </footer>
</template>
