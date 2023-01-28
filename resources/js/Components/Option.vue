<script setup>
import PlusSVG from "@/Components/PlusSVG.vue";
import DeleteSVG from "@/Components/DeleteSVG.vue";

import { ref } from "vue";
const props = defineProps({ index: Number });
const emits = defineEmits(["unrenderOption", "addOption"]);

const optionRef = ref("");
const inputsAreDisabled = ref(false);

const optionObject = () => {
    return {
        id: crypto.randomUUID(),
        text: optionRef.value,
    };
};
</script>
<template>
    <div class="flex items-center space-x-5">
        <p class="font-semibold">{{ props.index + 1 }}-.</p>
        <input
            :disabled="inputsAreDisabled"
            v-model="optionRef"
            type="text"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm disabled:bg-green-100 disabled:text-green-700"
        />
        <button
            v-if="!inputsAreDisabled"
            class="border-2 border-green-600 text-green-600 rounded-full hover:bg-green-600 hover:text-white"
            type="button"
            @click="
                () => {
                    emits('addOption', optionObject());
                    inputsAreDisabled = true;
                }
            "
        >
            <PlusSVG />
        </button>
        <button
            v-if="!inputsAreDisabled"
            class="border-2 border-red-600 text-red-600 rounded-full hover:bg-red-600 hover:text-white"
            type="button"
            @click="emits('unrenderOption')"
        >
            <DeleteSVG />
        </button>
    </div>
</template>
