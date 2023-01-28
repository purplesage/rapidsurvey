<script setup>
import PlusSVG from "@/Components/PlusSVG.vue";
import DeleteSVG from "@/Components/DeleteSVG.vue";
import { ref, onBeforeMount } from "vue";

const props = defineProps({ index: Number, optionObject: Object });
const emits = defineEmits(["deleteOption", "addOption"]);

const optionRef = ref("");

onBeforeMount(() => {
    if (props.optionObject.text) optionRef.value = props.optionObject.text;
});
const inputsAreDisabled = ref(false);

const newOptionObject = () => {
    return {
        id: props.optionObject.id,
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
                    emits('addOption', newOptionObject());
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
            @click="emits('deleteOption')"
        >
            <DeleteSVG />
        </button>
    </div>
</template>
