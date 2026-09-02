<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { createSafeObject, getSafeDistributionValue, setSafeDistributionValue, sanitizeMealName } from './utils/dietUtils.js';

const props = defineProps({
    equivalents: {
        type: Array,
        default: () => [],
    },
    meals: {
        type: Array,
        default: () => [],
    },
    modelValue: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(['update:modelValue']);

const isDetailsOpen = ref(false);

/*
|--------------------------------------------------------------------------
| EXTRAER METAS Y NOMBRES REALES
|--------------------------------------------------------------------------
*/
/* const formatSlug = (str) => {
    if (typeof str !== 'string') return '';
    return str
        .replace(/_/g, ' ')
        .replace(/-/g, ' ')
        .replace(/\b\w/g, (l) => l.toUpperCase());
}; */

const getTargetServings = (eq) => {
    if (!eq) return 0;
    if (typeof eq === 'number') return eq;
    return Number(eq.servings ?? eq.quantity ?? eq.total ?? 0) || 0;
};

// Lee la propiedad group_key directamente
/*const getSubgroupName = (eq) => {
    if (!eq) return 'Sin Nombre';

    const keyName = eq.group_key || eq.subgroup_key || eq.name || eq.nombre || eq.key;
    if (keyName) return formatSlug(String(keyName));

    return 'Sin Nombre';
};*/

// Genera la clave única usando group_key
const getSubgroupKey = (eq, index = 0) => {
    return eq.group_key || eq.subgroup_key || eq.key || `eq_${index}`;
};


/*
|--------------------------------------------------------------------------
| DICCIONARIO DE TRADUCCIÓN DE SUBGRUPOS
|--------------------------------------------------------------------------
*/
const subgroupTranslations = {
    vegetables: 'Verduras',
    fruits: 'Frutas',
    cereals_no_fat: 'Cereales sin grasa',
    cereals_fat: 'Cereales con grasa',
    legumes: 'Leguminosas',
    aoa_very_low_fat: 'AOA Muy bajo en grasa',
    aoa_low_fat: 'AOA Bajo en grasa',
    aoa_moderate_fat: 'AOA Moderado en grasa',
    aoa_high_fat: 'AOA Alto en grasa',
    milk_skimmed: 'Leche descremada',
    milk_semi: 'Leche semidescremada',
    milk_whole: 'Leche entera',
    oils_no_fat: 'Aceites sin proteína',
    oils_fat: 'Aceites con proteína',
    sugars_no_fat: 'Azúcares sin grasa',
    sugars_fat: 'Azúcares con grasa',
};

const formatSlug = (str) => {
    if (typeof str !== 'string') return '';
    return str
        .replace(/_/g, ' ')
        .replace(/-/g, ' ')
        .replace(/\b\w/g, (l) => l.toUpperCase());
};

const getSubgroupName = (eq) => {
    if (!eq) return 'Sin Nombre';

    const rawKey = eq.group_key || eq.subgroup_key || eq.name || eq.nombre || eq.key;
    if (!rawKey) return 'Sin Nombre';

    // Normalizar la clave (minúsculas, sin espacios extra y formateo de guiones)
    const cleanKey = String(rawKey).toLowerCase().trim().replace(/-/g, '_').replace(/\s+/g, '_');

    // Retorna la traducción en español si existe en el diccionario
    if (subgroupTranslations[cleanKey]) {
        return subgroupTranslations[cleanKey];
    }

    // Fallback: si entra una clave desconocida, la formatea automáticamente
    return formatSlug(String(rawKey));
};

/*
|--------------------------------------------------------------------------
| FILTRAR SOLO EQUIVALENTES CON META MAYOR A 0
|--------------------------------------------------------------------------
*/
const activeEquivalents = computed(() => {
    return (props.equivalents || []).filter((eq) => getTargetServings(eq) > 0);
});

/*
|--------------------------------------------------------------------------
| ALGORITMO DE AUTO-DISTRIBUCIÓN
|--------------------------------------------------------------------------
*/
const autoDistribute = () => {
    const newDistribution = createSafeObject();
    const mealNames = props.meals.map((m) => sanitizeMealName(m.name, 'Comida'));

    if (mealNames.length === 0 || !activeEquivalents.value.length) return;

    const mealWeights = {
        'Desayuno': 0.25,
        'Colación Mañana': 0.10,
        'Almuerzo': 0.35,
        'Colación Tarde': 0.10,
        'Cena': 0.20,
    };

    activeEquivalents.value.forEach((eq) => {
        const totalServings = getTargetServings(eq);
        const key = getSubgroupKey(eq);

        if (!key || totalServings <= 0) return;

        const safeSubgroup = createSafeObject();
        let distributedSum = 0;

        mealNames.forEach((mealName, index) => {
            if (index === mealNames.length - 1) {
                const remaining = Math.max(0, totalServings - distributedSum);
                safeSubgroup[mealName] = Math.round(remaining * 2) / 2;
                return;
            }

            const weight = mealWeights[mealName] || (1 / mealNames.length);
            let portion = Math.round(totalServings * weight * 2) / 2;

            if (distributedSum + portion > totalServings) {
                portion = Math.max(0, totalServings - distributedSum);
            }

            safeSubgroup[mealName] = portion;
            distributedSum += portion;
        });

        newDistribution[key] = safeSubgroup;
    });

    emit('update:modelValue', newDistribution);
};

onMounted(() => {
    if (!Object.keys(props.modelValue || {}).length) {
        autoDistribute();
    }
});

watch(
    () => props.equivalents,
    () => {
        autoDistribute();
    },
    { deep: true }
);

/*
|--------------------------------------------------------------------------
| RESUMEN PARA TARJETAS DE TIEMPOS DE COMIDA
|--------------------------------------------------------------------------
*/
const mealsSummary = computed(() => {
    return props.meals.map((meal) => {
        const assignedItems = [];

        activeEquivalents.value.forEach((eq) => {
            const key = getSubgroupKey(eq);
            const qty = getSafeDistributionValue(props.modelValue, key, meal.name);
            if (qty > 0) {
                assignedItems.push({
                    name: getSubgroupName(eq),
                    qty,
                });
            }
        });

        return {
            name: meal.name,
            items: assignedItems,
        };
    });
});

const getServings = (subgroupKey, mealName) => {
    return getSafeDistributionValue(props.modelValue, subgroupKey, mealName);
};

const updateServings = (subgroupKey, mealName, value) => {
    const numericValue = Math.max(0, Number(value) || 0);
    const updated = { ...props.modelValue };
    const safeMealName = sanitizeMealName(mealName, 'Comida');

    if (!updated[subgroupKey]) {
        updated[subgroupKey] = createSafeObject();
    }

    setSafeDistributionValue(updated, subgroupKey, safeMealName, numericValue);
    emit('update:modelValue', updated);
};

const getAssignedTotal = (subgroupKey) => {
    const subgroupDistribution = props.modelValue[subgroupKey] || createSafeObject();
    return Object.values(subgroupDistribution).reduce((sum, val) => sum + (Number(val) || 0), 0);
};

watch(
    () => props.equivalents,
    () => {
        autoDistribute();
    },
    { immediate: true, deep: true }
);

</script>

<template>
    <div class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <!-- Encabezado -->
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">
                    Distribución por Tiempo de Comida
                </h3>
                <p class="text-xs text-slate-500">
                    Asignación automática de grupos de equivalentes para cada comida del día.
                </p>
            </div>

            <button
                type="button"
                @click="autoDistribute"
                class="inline-flex items-center gap-1.5 self-start rounded-xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 sm:self-center"
            >
                ⚡ Recalcular Automáticamente
            </button>
        </div>

        <!-- TARJETAS REQUISITOS ACTIVOS -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            <div
                v-for="meal in mealsSummary"
                :key="meal.name"
                class="flex flex-col rounded-xl border border-slate-100 bg-slate-50/70 p-4"
            >
                <div class="mb-3 border-b border-slate-200/60 pb-2 text-center">
                    <h4 class="text-sm font-bold text-slate-700">{{ meal.name }}</h4>
                </div>

                <div v-if="meal.items.length" class="space-y-1.5 text-xs text-slate-600">
                    <div
                        v-for="(item, idx) in meal.items"
                        :key="idx"
                        class="flex items-center justify-between gap-1.5 rounded-lg bg-white p-2 shadow-2xs"
                    >
                        <span class="truncate font-medium text-slate-800" :title="item.name">
                            {{ item.name }}
                        </span>
                        <span class="shrink-0 rounded bg-emerald-100 px-1.5 py-0.5 text-[11px] font-bold text-emerald-700">
                            {{ item.qty }} eq
                        </span>
                    </div>
                </div>

                <p v-else class="my-auto py-4 text-center text-xs italic text-slate-400">
                    Sin equivalentes
                </p>
            </div>
        </div>

        <!-- BOTÓN TABLA DESPLEGABLE -->
        <div class="pt-2">
            <button
                type="button"
                @click="isDetailsOpen = !isDetailsOpen"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white py-3 text-xs font-bold text-slate-700 shadow-2xs transition hover:bg-slate-50"
            >
                <span>DETALLE Y AJUSTE DE EQUIVALENTES</span>
                <svg
                    class="h-4 w-4 transition-transform duration-200"
                    :class="{ 'rotate-180': isDetailsOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <!-- TABLA DETALLADA -->
        <div v-show="isDetailsOpen" class="overflow-x-auto pt-2">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-200 bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-3 font-semibold">Grupo / Subgrupo</th>
                        <th class="p-3 text-center font-semibold">Meta Total</th>
                        <th v-for="meal in meals" :key="meal.name" class="p-3 text-center font-semibold">
                            {{ meal.name }}
                        </th>
                        <th class="p-3 text-center font-semibold">Asignado</th>
                        <th class="p-3 text-center font-semibold">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="eq in activeEquivalents" :key="getSubgroupKey(eq)" class="hover:bg-slate-50/50">
                        <td class="p-3 font-medium text-slate-800">{{ getSubgroupName(eq) }}</td>

                        <td class="p-3 text-center font-bold text-slate-700">{{ getTargetServings(eq) }}</td>

                        <td v-for="meal in meals" :key="meal.name" class="p-2 text-center">
                            <input
                                type="number"
                                min="0"
                                step="0.5"
                                :value="getServings(getSubgroupKey(eq), meal.name)"
                                @input="updateServings(getSubgroupKey(eq), meal.name, $event.target.value)"
                                class="w-16 rounded-lg border-slate-300 py-1 text-center text-xs focus:border-emerald-500 focus:ring-emerald-500"
                            />
                        </td>

                        <td class="p-3 text-center font-bold text-slate-800">
                            {{ getAssignedTotal(getSubgroupKey(eq)) }}
                        </td>

                        <td class="p-3 text-center">
                            <span
                                v-if="getAssignedTotal(getSubgroupKey(eq)) === getTargetServings(eq)"
                                class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700"
                            >
                                ✓ Listo
                            </span>
                            <span
                                v-else-if="getAssignedTotal(getSubgroupKey(eq)) > getTargetServings(eq)"
                                class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-bold text-red-700"
                            >
                                Excedido
                            </span>
                            <span
                                v-else
                                class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700"
                            >
                                Pendiente
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
