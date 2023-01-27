<script setup>
const props = defineProps({
    survey: Object,
});
</script>
<template>
    <h1>{{ props.survey.title }}</h1>
</template>
