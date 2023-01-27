<script setup>
import { ref } from "vue";

const optionRef = ref("");
const emits = defineEmits(["unrenderOption", "addOption"]);

const optionObject = () => {
    return {
        id: crypto.randomUUID(),
        text: optionRef.value,
    };
};
</script>
<template>
    <div>
        1-. <input v-model="optionRef" type="text" />
        <button type="button" @click="emits('unrenderOption')">delete</button>
        <button type="button" @click="emits('addOption', optionObject())">
            add
        </button>
    </div>
</template>
