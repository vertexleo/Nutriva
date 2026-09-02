<script setup>
import { computed } from 'vue';

const props = defineProps({
  targets: Object,
  currentTotals: Object
});

const getPercentage = (current, target) => {
  if (!target) return 0;
  return Math.min(Math.round((current / target) * 100), 100);
};
</script>

<template>
  <div class="bg-white border rounded-xl shadow-sm p-5 space-y-4">
    <h3 class="font-bold text-gray-800 border-b pb-2 text-sm">Resumen Nutricional</h3>

    <!-- Comparativa de Calorías -->
    <div class="space-y-1">
      <div class="flex justify-between text-xs font-semibold">
        <span>Calorías:</span>
        <span>{{ Math.round(currentTotals.calories) }} / {{ targets.targetCalories }} kcal</span>
      </div>
      <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
        <div class="bg-emerald-500 h-full transition-all" :style="{ width: getPercentage(currentTotals.calories, targets.targetCalories) + '%' }"></div>
      </div>
    </div>

    <!-- Comparativa de Proteínas -->
    <div class="space-y-1">
      <div class="flex justify-between text-xs font-semibold">
        <span>Proteínas:</span>
        <span>{{ Math.round(currentTotals.protein) }} / {{ targets.proteinGrams }} g</span>
      </div>
      <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
        <div class="bg-blue-500 h-full transition-all" :style="{ width: getPercentage(currentTotals.protein, targets.proteinGrams) + '%' }"></div>
      </div>
    </div>

    <!-- Comparativa de Carbohidratos -->
    <div class="space-y-1">
      <div class="flex justify-between text-xs font-semibold">
        <span>Carbohidratos:</span>
        <span>{{ Math.round(currentTotals.carbs) }} / {{ targets.carbsGrams }} g</span>
      </div>
      <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
        <div class="bg-amber-500 h-full transition-all" :style="{ width: getPercentage(currentTotals.carbs, targets.carbsGrams) + '%' }"></div>
      </div>
    </div>

    <!-- Comparativa de Grasas -->
    <div class="space-y-1">
      <div class="flex justify-between text-xs font-semibold">
        <span>Grasas:</span>
        <span>{{ Math.round(currentTotals.fat) }} / {{ targets.fatGrams }} g</span>
      </div>
      <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
        <div class="bg-rose-500 h-full transition-all" :style="{ width: getPercentage(currentTotals.fat, targets.fatGrams) + '%' }"></div>
      </div>
    </div>
  </div>
</template>
