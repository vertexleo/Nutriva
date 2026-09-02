<script setup>
import { Head, Link } from '@inertiajs/vue3';

import Navbar from '@/Components/Navbar.vue'
import Hero from '@/Components/Hero.vue'
import Features from '@/Components/Features.vue'
import Footer from '@/Components/Footer.vue'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />

    <Navbar />

    <Hero />

    <Features />

    <Footer />
</template>
