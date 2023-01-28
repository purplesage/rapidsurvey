<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SurveyForm from "@/Components/SurveyForm.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({ survey: Object });
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.survey?.title }}
            </h2>
        </template>

        <SurveyForm :survey="props.survey" :isEditing="true" />
    </AuthenticatedLayout>
</template>
