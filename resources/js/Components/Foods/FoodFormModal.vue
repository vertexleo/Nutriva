<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps({
    show: Boolean,
    food: Object,
    categories: Array,
});

const emit = defineEmits(['close']);

const form = useForm({
    id: null,
    name: '',
    category: 'Verduras',
    portion: 100,
    unit: 'g',
    calories: 0,
    protein: 0,
    carbs: 0,
    fat: 0,
});

watch(
    () => props.food,
    (newFood) => {
        form.clearErrors();
        if (newFood) {
            form.id = newFood.id;
            form.name = newFood.name;
            form.category = newFood.category ?? 'Verduras';
            form.portion = newFood.portion;
            form.unit = newFood.unit;
            form.calories = newFood.calories;
            form.protein = newFood.protein;
            form.carbs = newFood.carbs;
            form.fat = newFood.fat;
        } else {
            form.reset();
            form.id = null;
        }
    },
    { immediate: true }
);

const submit = () => {
    if (form.id) {
        form.put(route('foods.update', form.id), {
            onSuccess: () => emit('close'),
        });
    } else {
        form.post(route('foods.store'), {
            onSuccess: () => emit('close'),
        });
    }
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h2 class="text-lg font-bold text-slate-800">
                    {{ form.id ? 'Editar Alimento' : 'Nuevo Alimento' }}
                </h2>
                <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Nombre</label>
                    <input
                        type="text"
                        v-model="form.name"
                        placeholder="Ej. Pechuga de pollo cocida"
                        class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                    />
                    <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Categoría</label>
                        <select v-model="form.category" class="w-full rounded-xl border-slate-300 text-sm">
                            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Porción</label>
                            <input type="number" step="0.1" v-model="form.portion" class="w-full rounded-xl border-slate-300 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Unidad</label>
                            <input type="text" v-model="form.unit" class="w-full rounded-xl border-slate-300 text-sm" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Calorías (kcal)</label>
                        <input type="number" step="0.1" v-model="form.calories" class="w-full rounded-xl border-slate-300 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Proteínas (g)</label>
                        <input type="number" step="0.1" v-model="form.protein" class="w-full rounded-xl border-slate-300 text-sm" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Carbohidratos (g)</label>
                        <input type="number" step="0.1" v-model="form.carbs" class="w-full rounded-xl border-slate-300 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Grasas (g)</label>
                        <input type="number" step="0.1" v-model="form.fat" class="w-full rounded-xl border-slate-300 text-sm" />
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-semibold text-white hover:bg-emerald-700 disabled:opacity-50"
                    >
                        {{ form.id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
