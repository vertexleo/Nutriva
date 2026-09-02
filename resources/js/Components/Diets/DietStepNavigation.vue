<script setup>
defineProps({ activeStep: Number });
defineEmits(['update:activeStep']);

const steps = [
  { id: 1, title: '1. Cálculo Energético' },
  { id: 2, title: '2. Equivalentes' },
  { id: 3, title: '3. Plan Alimentario' },
];
</script>

<template>
  <nav class="flex border-b border-gray-200 bg-white rounded-xl shadow-sm overflow-hidden">
    <button
      v-for="step in steps"
      :key="step.id"
      @click="$emit('update:activeStep', step.id)"
      :class="[
        activeStep === step.id ? 'bg-emerald-50 text-emerald-700 border-b-2 border-emerald-600 font-bold' : 'text-gray-500 hover:text-gray-700',
        'flex-1 py-4 text-center text-sm transition-all'
      ]"
    >
      {{ step.title }}
    </button>
  </nav>
</template>
