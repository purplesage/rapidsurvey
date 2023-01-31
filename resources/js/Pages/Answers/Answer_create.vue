<script setup>
import AnswerForm from "@/Components/AnswerForm.vue";
const props = defineProps({
    survey: Object,
});
</script>
<template>
    <AnswerForm :survey="props.survey" />
</template>
