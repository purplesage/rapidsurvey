<script setup>
import DeleteSVG from "@/Components/DeleteSVG.vue";

const props = defineProps({
    index: Number,
    optionObject: Object,
});
const emits = defineEmits(["deleteOption", "addOption"]);
</script>
<template>
    <div class="flex items-center space-x-5">
        <p class="font-semibold">{{ props.index + 1 }}-.</p>
        <input
            v-model="optionObject.text"
            type="text"
            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-green-100 disabled:text-green-700"
        />

        <button
            class="rounded-full border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white"
            type="button"
            @click="emits('deleteOption')"
        >
            <DeleteSVG />
        </button>
    </div>
</template>
