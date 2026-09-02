<script setup>
import { computed, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    targetCalories: {
        type: [Number, String],
        default: 1800,
    },
});

const emit = defineEmits(['update:modelValue', 'update:totals']);

/*
|--------------------------------------------------------------------------
| Grupos y Subgrupos con constantes nutricionales
|--------------------------------------------------------------------------
*/
const groups = [
    {
        name: 'Verduras',
        subgroups: [
            { key: 'vegetables', name: 'Verduras', description: 'Verduras y hortalizas', kcal: 25, protein: 2, carbs: 4, fat: 0 },
        ],
    },
    {
        name: 'Frutas',
        subgroups: [
            { key: 'fruits', name: 'Frutas', description: 'Frutas frescas y sus equivalentes', kcal: 60, protein: 0, carbs: 15, fat: 0 },
        ],
    },
    {
        name: 'Cereales y tubérculos',
        subgroups: [
            { key: 'cereals_no_fat', name: 'Sin grasa', description: 'Arroz, avena, pan, pasta, quinua, etc.', kcal: 70, protein: 2, carbs: 15, fat: 0 },
            { key: 'cereals_fat', name: 'Con grasa', description: 'Galletas rellenas, papas fritas, pan dulce, etc.', kcal: 115, protein: 2, carbs: 15, fat: 5 },
        ],
    },
    {
        name: 'Leguminosas',
        subgroups: [
            { key: 'legumes', name: 'Leguminosas', description: 'Lentejas, frejoles, garbanzos, etc.', kcal: 120, protein: 8, carbs: 20, fat: 1 },
        ],
    },
    {
        name: 'Alimentos de Origen Animal (AOA)',
        subgroups: [
            { key: 'aoa_very_low_fat', name: 'Muy bajo aporte de grasa', description: 'Pechuga de pollo, clara de huevo, pescado blanco', kcal: 40, protein: 7, carbs: 0, fat: 1 },
            { key: 'aoa_low_fat', name: 'Bajo aporte de grasa', description: 'Carne magra de res, muslo de pollo sin piel, queso fresco', kcal: 55, protein: 7, carbs: 0, fat: 3 },
            { key: 'aoa_moderate_fat', name: 'Moderado aporte de grasa', description: 'Huevo entero, carne semigrasa, queso mozzarella', kcal: 75, protein: 7, carbs: 0, fat: 5 },
            { key: 'aoa_high_fat', name: 'Alto aporte de grasa', description: 'Queso maduro, embutidos, chuleta de cerdo', kcal: 100, protein: 7, carbs: 0, fat: 8 },
        ],
    },
    {
        name: 'Leche',
        subgroups: [
            { key: 'milk_skimmed', name: 'Descremada', description: 'Leche o yogurt descremado', kcal: 95, protein: 9, carbs: 12, fat: 2 },
            { key: 'milk_semi', name: 'Semidescremada', description: 'Leche o yogurt semidescremado', kcal: 110, protein: 9, carbs: 12, fat: 4 },
            { key: 'milk_whole', name: 'Entera', description: 'Leche o yogurt entero', kcal: 150, protein: 9, carbs: 12, fat: 8 },
            { key: 'milk_sugar', name: 'Con azúcar', description: 'Leche condensada, yogurts con sabor/azúcar', kcal: 200, protein: 8, carbs: 30, fat: 5 },
        ],
    },
    {
        name: 'Aceites y grasas',
        subgroups: [
            { key: 'fats_no_protein', name: 'Sin proteína', description: 'Aceite de oliva, palta, mantequilla, mayonesa', kcal: 45, protein: 0, carbs: 0, fat: 5 },
            { key: 'fats_protein', name: 'Con proteína', description: 'Nueces, almendras, maní, semillas', kcal: 70, protein: 3, carbs: 3, fat: 5 },
        ],
    },
    {
        name: 'Azúcares',
        subgroups: [
            { key: 'sugars_no_fat', name: 'Sin grasa', description: 'Azúcar de mesa, miel, mermelada, gelatinas', kcal: 40, protein: 0, carbs: 10, fat: 0 },
            { key: 'sugars_fat', name: 'Con grasa', description: 'Chocolates, helados cremosos, postres', kcal: 85, protein: 0, carbs: 10, fat: 5 },
        ],
    },
];

/*
|--------------------------------------------------------------------------
| Mapeo y Búsqueda
|--------------------------------------------------------------------------
*/
const subgroupLookup = computed(() => {
    const map = {};
    groups.forEach((g) => {
        g.subgroups.forEach((sub) => {
            map[sub.key] = sub;
        });
    });
    return map;
});

const totalSubgroupsCount = computed(() => {
    return groups.reduce((acc, g) => acc + g.subgroups.length, 0);
});

/*
|--------------------------------------------------------------------------
| Gestores de datos
|--------------------------------------------------------------------------
*/
const getEquivalent = (key) => {
    if (!Array.isArray(props.modelValue)) {
        return { group_key: key, servings: 0 };
    }
    return (
        props.modelValue.find((item) => item.group_key === key) || {
            group_key: key,
            servings: 0,
        }
    );
};

const updateServings = (key, value) => {
    const rawValue = Number(value);
    const numericValue = isNaN(rawValue) || rawValue < 0 ? 0 : rawValue;
    const currentList = Array.isArray(props.modelValue) ? props.modelValue : [];

    const exists = currentList.some((item) => item.group_key === key);

    let updatedList = [];
    if (exists) {
        updatedList = currentList.map((item) =>
            item.group_key === key ? { ...item, servings: numericValue } : { ...item }
        );
    } else {
        updatedList = [...currentList, { group_key: key, servings: numericValue }];
    }

    emit('update:modelValue', updatedList);
};

/*
|--------------------------------------------------------------------------
| Métricas Generales
|--------------------------------------------------------------------------
*/
const totalEquivalents = computed(() => {
    if (!Array.isArray(props.modelValue)) return 0;
    return props.modelValue.reduce(
        (total, eq) => total + (Number(eq.servings) || 0),
        0
    );
});

const activeGroups = computed(() => {
    if (!Array.isArray(props.modelValue)) return 0;
    return props.modelValue.filter((eq) => Number(eq.servings) > 0).length;
});

/*
|--------------------------------------------------------------------------
| Cálculo Dinámico del Resumen Nutricional
|--------------------------------------------------------------------------
*/
const nutritionSummary = computed(() => {
    let calories = 0;
    let protein = 0;
    let carbs = 0;
    let fat = 0;

    if (Array.isArray(props.modelValue)) {
        props.modelValue.forEach((item) => {
            const servings = Number(item.servings) || 0;
            const sub = subgroupLookup.value[item.group_key];

            if (sub && servings > 0) {
                calories += servings * sub.kcal;
                protein += servings * sub.protein;
                carbs += servings * sub.carbs;
                fat += servings * sub.fat;
            }
        });
    }

    const proteinPct = calories > 0 ? Math.round(((protein * 4) / calories) * 100) : 0;
    const carbsPct = calories > 0 ? Math.round(((carbs * 4) / calories) * 100) : 0;
    const fatPct = calories > 0 ? Math.round(((fat * 9) / calories) * 100) : 0;

    const target = Number(props.targetCalories) || 0;
    const diffCalories = calories - target;
    const targetPct = target > 0 ? Math.min(Math.round((calories / target) * 100), 100) : 0;

    return {
        calories: Math.round(calories),
        protein: protein.toFixed(1),
        carbs: carbs.toFixed(1),
        fat: fat.toFixed(1),
        proteinPct,
        carbsPct,
        fatPct,
        diffCalories,
        targetPct,
    };
});

/*
|--------------------------------------------------------------------------
| Sincronización con el componente padre
|--------------------------------------------------------------------------
*/
watch(
    nutritionSummary,
    (newSummary) => {
        emit('update:totals', newSummary);
    },
    { immediate: true, deep: true }
);
</script>

<template>
    <section class="space-y-6">
        <!-- Encabezado -->
        <div>
            <h2 class="text-lg font-bold text-slate-800">
                Distribución por equivalentes
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Define cuántas porciones de cada grupo y subgrupo de alimentos tendrá el plan nutricional.
            </p>
        </div>

        <!-- Tarjetas de Total de Equivalentes -->
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Total de equivalentes
                </p>
                <p class="mt-2 text-2xl font-bold text-slate-800">
                    {{ totalEquivalents }}
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    Porciones distribuidas en el plan
                </p>
            </div>

            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">
                    Subgrupos utilizados
                </p>
                <p class="mt-2 text-2xl font-bold text-emerald-700">
                    {{ activeGroups }}
                </p>
                <p class="mt-1 text-xs text-emerald-600">
                    De {{ totalSubgroupsCount }} subgrupos disponibles
                </p>
            </div>
        </div>

        <!-- Tabla con Grupos y Subgrupos -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-slate-100 bg-slate-50">
                        <tr>
                            <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Grupo / Subgrupo
                            </th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Descripción
                            </th>
                            <th class="w-40 px-5 py-4 text-center text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Equivalentes
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template v-for="group in groups" :key="group.name">
                            <tr class="bg-slate-50/80 font-bold">
                                <td colspan="3" class="px-5 py-2.5 text-xs uppercase tracking-wider text-emerald-700">
                                    {{ group.name }}
                                </td>
                            </tr>
                            <tr
                                v-for="sub in group.subgroups"
                                :key="sub.key"
                                class="transition hover:bg-slate-50/70"
                            >
                                <td class="px-5 py-3.5 pl-8">
                                    <div class="font-medium text-slate-800 text-sm">
                                        {{ sub.name }}
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-xs text-slate-500">
                                        {{ sub.description }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <input
                                        type="number"
                                        min="0"
                                        step="0.5"
                                        :value="getEquivalent(sub.key).servings"
                                        @input="updateServings(sub.key, $event.target.value)"
                                        class="w-full rounded-xl border-slate-300 text-center font-semibold text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    />
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Banner Informativo -->
        <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
            <div class="flex gap-3">
                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-600">
                    i
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-800">
                        Distribución de equivalentes
                    </p>
                    <p class="mt-1 text-xs leading-5 text-blue-700">
                        Los equivalentes representan porciones de cada grupo de alimentos. Esta distribución servirá como base para construir posteriormente las comidas del plan.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
