<script setup>
import { computed } from "vue";

const props = defineProps({
    title: String,
    value: [String, Number],
    color: {
        type: String,
        default: "emerald",
    },
    icon: {
        type: [Object, Function, String],
        default: null,
    },
    change: {
        type: String,
        default: "",
    },
});

const colors = {
    emerald: {
        bg: "bg-emerald-50",
        text: "text-emerald-600",
    },
    blue: {
        bg: "bg-blue-50",
        text: "text-blue-600",
    },
    orange: {
        bg: "bg-orange-50",
        text: "text-orange-500",
    },
    purple: {
        bg: "bg-purple-50",
        text: "text-purple-600",
    },
};

const currentColor = computed(() => colors[props.color] || colors.emerald);
</script>

<template>
    <div
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md"
    >
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    {{ title }}
                </p>

                <h2 class="mt-3 text-3xl font-bold text-slate-800">
                    {{ value }}
                </h2>

                <p
                    v-if="change"
                    class="mt-2 text-sm text-slate-500"
                >
                    {{ change }}
                </p>
            </div>

            <div
                :class="[currentColor.bg, currentColor.text]"
                class="flex h-12 w-12 items-center justify-center rounded-xl"
            >
                <component
                    v-if="icon"
                    :is="icon"
                    class="h-6 w-6"
                />
            </div>
        </div>
    </div>
</template>
