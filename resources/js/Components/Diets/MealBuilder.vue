<script setup>
import MealCard from './MealCard.vue';

const props = defineProps({ meals: Array });
const emit = defineEmits(['update:meals']);

const addMeal = () => {
  const newMeals = [...props.meals, { id: Date.now(), name: 'Nueva Comida', items: [] }];
  emit('update:meals', newMeals);
};

const removeMeal = (index) => {
  const newMeals = [...props.meals];
  newMeals.splice(index, 1);
  emit('update:meals', newMeals);
};
</script>

<template>
  <div class="space-y-4">
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-bold text-gray-800">Paso 3: Tiempos de Comida</h2>
      <button @click="addMeal" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">
        + Agregar Tiempo de Comida
      </button>
    </div>

    <MealCard
      v-for="(meal, index) in meals"
      :key="meal.id"
      :meal="meal"
      @remove="removeMeal(index)"
    />
  </div>
</template>
