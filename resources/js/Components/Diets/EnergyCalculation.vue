<script setup>
import { ref, watch, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  energyData: Object,
  patientId: [Number, String],
  patients: {
    type: Array,
    default: () => []
  }
});

const emit = defineEmits(['update:energyData', 'update:patientId']);

// ==========================================
// FUNCIÓN ÚNICA: Lógica del Buscador y Desplegable
// ==========================================
function usePatientDropdown(props, emit) {
  const searchQuery = ref('');
  const isOpen = ref(false);
  const dropdownRef = ref(null);

  const selectedPatient = computed(() => {
    return props.patients.find(p => p.id === props.patientId) || null;
  });

  const formatPatientLabel = (p) => {
    if (!p) return '';
    const fullName = `${p.first_name || ''} ${p.last_name || ''}`.trim();
    const dni = p.dni ? ` | DNI: ${p.dni}` : '';
    return `${fullName}${dni}`;
  };

  watch(() => props.patientId, () => {
    if (selectedPatient.value) {
      searchQuery.value = formatPatientLabel(selectedPatient.value);
    } else {
      searchQuery.value = '';
    }
  }, { immediate: true });

  const filteredPatients = computed(() => {
    if (!props.patients || !props.patients.length) return [];
    if (!searchQuery.value.trim()) return props.patients;

    if (selectedPatient.value && searchQuery.value === formatPatientLabel(selectedPatient.value)) {
      return props.patients;
    }

    const query = searchQuery.value.toLowerCase().trim();

    return props.patients.filter(p => {
      const firstName = (p.first_name || '').toLowerCase();
      const lastName = (p.last_name || '').toLowerCase();
      const fullName = `${firstName} ${lastName}`.trim();
      const dni = (p.dni || '').toString().toLowerCase();

      return fullName.includes(query) || firstName.includes(query) || lastName.includes(query) || dni.includes(query);
    });
  });

  const selectPatient = (patient) => {
    emit('update:patientId', patient.id);
    searchQuery.value = formatPatientLabel(patient);
    isOpen.value = false;
  };

  const handleInput = () => {
    isOpen.value = true;
    if (!searchQuery.value) {
      emit('update:patientId', null);
    }
  };

  const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
      isOpen.value = false;
    }
  };

  onMounted(() => document.addEventListener('click', handleClickOutside));
  onUnmounted(() => document.removeEventListener('click', handleClickOutside));

  return {
    searchQuery,
    isOpen,
    dropdownRef,
    filteredPatients,
    selectPatient,
    handleInput
  };
}

// Inicialización de la función del buscador
const {
  searchQuery,
  isOpen,
  dropdownRef,
  filteredPatients,
  selectPatient,
  handleInput
} = usePatientDropdown(props, emit);

// ==========================================
// Lógica de Cálculo Energético
// ==========================================
const formula = ref('mifflin');
const activityFactor = ref(1.55);
const weight = ref(82);
const height = ref(178);
const age = ref(32);
const isMale = ref(true);

const targetCalories = ref(2400);
const pctProtein = ref(30);
const pctCarbs = ref(40);
const pctFat = ref(30);

const calculateRequirements = () => {
  let tmb = (10 * weight.value) + (6.25 * height.value) - (5 * age.value) + (isMale.value ? 5 : -161);
  let tdee = tmb * activityFactor.value;

  const pGrams = (targetCalories.value * (pctProtein.value / 100)) / 4;
  const cGrams = (targetCalories.value * (pctCarbs.value / 100)) / 4;
  const fGrams = (targetCalories.value * (pctFat.value / 100)) / 9;

  emit('update:energyData', {
    tmb: Math.round(tmb),
    tdee: Math.round(tdee),
    targetCalories: targetCalories.value,
    proteinGrams: Math.round(pGrams),
    carbsGrams: Math.round(cGrams),
    fatGrams: Math.round(fGrams),
  });
};

watch([weight, height, age, targetCalories, pctProtein, pctCarbs, pctFat], calculateRequirements, { immediate: true });</script>

<template>
  <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <h2 class="text-lg font-bold text-gray-800 border-b pb-2">Paso 1: Requerimiento Energético</h2>

    <div class="grid grid-cols-2 gap-4">


        <!-- BUSCADOR CON DESPLEGABLE (COMBOBOX) -->
      <div class="relative" ref="dropdownRef">
        <label class="block text-xs font-semibold text-gray-600 mb-1">Paciente</label>

        <div class="relative">
          <input
            type="text"
            v-model="searchQuery"
            @focus="handleInputFocus"
            @input="handleInput"
            placeholder="Buscar por nombre o DNI..."
            class="w-full border rounded-lg p-2 text-sm pr-8 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
          />
          <!-- Ícono o flecha indicatoria -->
          <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>

        <!-- Menú Desplegable con Coincidencias -->
        <div
          v-if="isOpen"
          class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
        >
          <ul v-if="filteredPatients.length > 0" class="py-1 text-sm text-gray-700">
            <li
              v-for="patient in filteredPatients"
              :key="patient.id"
              @click="selectPatient(patient)"
              class="px-4 py-2 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer flex justify-between items-center transition"
            >
              <div>
                <span class="font-medium">{{ patient.first_name }} {{ patient.last_name }}</span>
                <span v-if="patient.dni" class="text-xs text-gray-400 block">DNI: {{ patient.dni }}</span>
              </div>
              <span v-if="patient.id === patientId" class="text-emerald-600 font-bold">✓</span>
            </li>
          </ul>

          <!-- Mensaje cuando no hay coincidencias -->
          <div v-else class="px-4 py-3 text-xs text-gray-500 text-center">
            No se encontraron pacientes con "{{ searchQuery }}"
          </div>
        </div>
      </div>


      <div>
        <label class="text-xs font-semibold text-gray-600">Fórmula de TMB</label>
        <select v-model="formula" class="w-full border rounded-lg p-2 text-sm">
          <option value="mifflin">Mifflin-St Jeor</option>
          <option value="harris">Harris-Benedict</option>
        </select>
      </div>
    </div>

    <!-- Modificación de Calorías y Distribución de Macros -->
    <div class="space-y-4 pt-2">
      <div class="flex justify-between items-center">
        <label class="text-sm font-semibold">Calorías Objetivo (kcal):</label>
        <input type="number" v-model.number="targetCalories" class="border rounded-lg p-2 w-32 text-right font-bold text-emerald-600" />
      </div>

      <div class="grid grid-cols-3 gap-3 text-center text-xs">
        <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
          <span class="block font-semibold text-blue-800">Proteína (30%)</span>
          <span class="text-lg font-bold text-blue-900">{{ energyData.proteinGrams }} g</span>
        </div>
        <div class="bg-amber-50 p-3 rounded-lg border border-amber-100">
          <span class="block font-semibold text-amber-800">Carbohidratos (40%)</span>
          <span class="text-lg font-bold text-amber-900">{{ energyData.carbsGrams }} g</span>
        </div>
        <div class="bg-rose-50 p-3 rounded-lg border border-rose-100">
          <span class="block font-semibold text-rose-800">Grasas (30%)</span>
          <span class="text-lg font-bold text-rose-900">{{ energyData.fatGrams }} g</span>
        </div>
      </div>
    </div>
  </div>
</template>
