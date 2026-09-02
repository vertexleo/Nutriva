<script setup>
import Sidebar from './Sidebar.vue'
import Topbar from './Topbar.vue'
import Footer from './Footer.vue'
</script>

<template>
    <div class="flex h-screen bg-slate-50">

        <!-- Sidebar -->
        <Sidebar />

        <!-- Contenido principal -->
        <div class="flex flex-1 flex-col overflow-hidden">

            <!-- Barra superior -->
            <Topbar />

            <!-- Contenido -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="mx-auto max-w-7xl">
                    <slot />
                </div>
            </main>

            <!-- Footer -->
            <Footer />

        </div>

    </div>
</template>
