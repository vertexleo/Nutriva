<script setup>
import { ref, reactive, computed } from 'vue';
import DietStepNavigation from './DietStepNavigation.vue';
import EnergyCalculation from './EnergyCalculation.vue';
import EquivalentTable from './EquivalentTable.vue';
import MealBuilder from './MealBuilder.vue';
import NutritionSummary from './NutritionSummary.vue';

const props = defineProps({
    diet: Object,
    patients: {
        type: Array,
        default: () => [],
    },
    foods: {
        type: Array,
        default: () => [],
    },
    isEditing: Boolean,
});

const currentStep = ref(1);

// Estado Global de la Dieta
const dietPlan = reactive({
  patient_id: null,
  patientData: null,
  energy: { tmb: 0, tdee: 0, targetCalories: 0, proteinGrams: 0, carbsGrams: 0, fatGrams: 0 },
  equivalents: [],
  meals: [
    { id: Date.now(), name: '☀️ Desayuno', items: [] },
    { id: Date.now() + 1, name: '🍽️ Almuerzo', items: [] },
    { id: Date.now() + 2, name: '🌙 Cena', items: [] }
  ],
  status: 'draft'
});

// Totales Calculados del Menú Real (Paso 3)
const realMenuTotals = computed(() => {
  return dietPlan.meals.reduce((acc, meal) => {
    meal.items.forEach(item => {
      const factor = (item.amount || 0) / (item.portion_base || 100);
      acc.calories += (item.calories || 0) * factor;
      acc.protein += (item.protein || 0) * factor;
      acc.carbs += (item.carbs || 0) * factor;
      acc.fat += (item.fat || 0) * factor;
    });
    return acc;
  }, { calories: 0, protein: 0, carbs: 0, fat: 0 });
});

const submitDietPlan = () => {
  // Lógica de validación previa al envío a Laravel (Inertia/Axios)
  console.log('Guardando Plan Nutricional:', dietPlan);
};
</script>

<template>
  <div class="max-w-7xl mx-auto p-6 space-y-6 bg-gray-50 min-h-screen">
    <!-- Navegación de Pasos -->
    <DietStepNavigation v-model:activeStep="currentStep" />

    <!-- Área de Contenido Dinámico por Paso -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 space-y-6">

        <!-- PASO 1: Requerimiento Energético -->
        <EnergyCalculation
          v-if="currentStep === 1"
          v-model:energyData="dietPlan.energy"
          v-model:patientId="dietPlan.patient_id"
          :patients="patients"
        />

        <!-- PASO 2: Distribución de Equivalentes -->
        <EquivalentTable
          v-if="currentStep === 2"
          v-model:equivalents="dietPlan.equivalents"
          :targetCalories="dietPlan.energy.targetCalories"
        />

        <!-- PASO 3: Construcción de Menú Concreto -->
        <MealBuilder
          v-if="currentStep === 3"
          v-model:meals="dietPlan.meals"
        />
      </div>

      <!-- Resumen Nutricional Transversal y Guardado -->
      <div class="lg:col-span-1">
        <div class="sticky top-6 space-y-4">
          <NutritionSummary
            :targets="dietPlan.energy"
            :currentTotals="realMenuTotals"
          />

          <button
            @click="submitDietPlan"
            class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition"
          >
            Guardar Plan Nutricional
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
