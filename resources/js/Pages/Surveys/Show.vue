<script setup>
const props = defineProps({
    survey: Object,
});
</script>
<template>
    <h1>{{ survey.title }}</h1>
</template>
