<script setup>
import FoodSelector from './FoodSelector.vue';

const props = defineProps({ meal: Object });
defineEmits(['remove']);

const addFood = (food) => {
  props.meal.items.push({
    food_id: food.id,
    name: food.name,
    amount: 100,
    portion_base: food.portion || 100,
    unit: food.unit || 'g',
    calories: food.calories,
    protein: food.protein,
    carbs: food.carbs,
    fat: food.fat
  });
};

const removeItem = (idx) => props.meal.items.splice(idx, 1);
</script>

<template>
  <div class="bg-white border rounded-xl shadow-sm p-4 space-y-3">
    <div class="flex justify-between items-center border-b pb-2">
      <input v-model="meal.name" class="font-bold text-gray-800 bg-transparent border-none p-0 focus:ring-0" />
      <button @click="$emit('remove')" class="text-xs text-red-500 hover:underline">Eliminar Comida</button>
    </div>

    <!-- Lista de Alimentos Agregados -->
    <div v-for="(item, idx) in meal.items" :key="idx" class="flex justify-between items-center bg-gray-50 p-2 rounded text-xs">
      <span class="font-medium w-1/3 truncate">{{ item.name }}</span>
      <div class="flex items-center space-x-1">
        <input type="number" v-model.number="item.amount" class="w-16 text-right border rounded p-1" />
        <span>{{ item.unit }}</span>
      </div>
      <div class="text-right text-gray-600">
        {{ Math.round((item.calories * item.amount) / item.portion_base) }} kcal
      </div>
      <button @click="removeItem(idx)" class="text-red-400 font-bold ml-2">✕</button>
    </div>

    <FoodSelector @select="addFood" />
  </div>
</template>
