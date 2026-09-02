<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    foods: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['select-food']);

const search = ref('');
const selectedFoodId = ref('');

/*
|--------------------------------------------------------------------------
| Filtrar alimentos
|--------------------------------------------------------------------------
*/

const filteredFoods = computed(() => {
    const term = search.value.trim().toLowerCase();

    if (!term) {
        return props.foods;
    }

    return props.foods.filter((food) => {
        return (
            food.name?.toLowerCase().includes(term) ||
            food.category?.toLowerCase().includes(term)
        );
    });
});

/*
|--------------------------------------------------------------------------
| Seleccionar alimento
|--------------------------------------------------------------------------
*/

const selectFood = () => {
    if (!selectedFoodId.value) {
        return;
    }

    const food = props.foods.find(
        (item) => String(item.id) === String(selectedFoodId.value)
    );

    if (!food) {
        return;
    }

    /*
     * Se crea una copia para que MealCard / MealBuilder
     * puedan modificar la porción sin alterar el catálogo.
     */

    emit('select-food', {
        food_id: food.id,
        name: food.name,
        portion: Number(food.portion ?? 1),
        unit: food.unit ?? 'g',
        calories: Number(food.calories ?? 0),
        protein: Number(food.protein ?? 0),
        carbs: Number(food.carbs ?? 0),
        fat: Number(food.fat ?? 0),
    });

    selectedFoodId.value = '';
};
</script>

<template>
    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

        <!-- Encabezado -->

        <div class="mb-3">

            <h4 class="text-sm font-semibold text-slate-800">
                Agregar alimento
            </h4>

            <p class="mt-1 text-xs text-slate-400">
                Busca un alimento en el catálogo y agrégalo a este tiempo de comida.
            </p>

        </div>

        <!-- Controles -->

        <div class="flex flex-col gap-3 md:flex-row">

            <!-- Buscador -->

            <div class="flex-1">

                <input
                    v-model="search"
                    type="text"
                    placeholder="Buscar alimento..."
                    class="w-full rounded-xl border-slate-300 bg-white text-sm text-slate-700 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
                />

            </div>

            <!-- Selector -->

            <div class="flex-1">

                <select
                    v-model="selectedFoodId"
                    class="w-full rounded-xl border-slate-300 bg-white text-sm text-slate-700 focus:border-emerald-500 focus:ring-emerald-500"
                >

                    <option value="">
                        Seleccionar alimento...
                    </option>

                    <option
                        v-for="food in filteredFoods"
                        :key="food.id"
                        :value="food.id"
                    >
                        {{ food.name }}
                        <template v-if="food.portion">
                            — {{ food.portion }} {{ food.unit }}
                        </template>
                    </option>

                </select>

            </div>

            <!-- Botón -->

            <button
                type="button"
                @click="selectFood"
                :disabled="!selectedFoodId"
                class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
            >
                + Agregar
            </button>

        </div>

        <!-- Información del resultado -->

        <div
            v-if="search && filteredFoods.length === 0"
            class="mt-3 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-700"
        >
            No se encontraron alimentos con "{{ search }}".
        </div>

        <div
            v-else-if="search"
            class="mt-3 text-xs text-slate-400"
        >
            {{ filteredFoods.length }}
            {{ filteredFoods.length === 1 ? 'alimento encontrado' : 'alimentos encontrados' }}
        </div>

    </div>
</template>
