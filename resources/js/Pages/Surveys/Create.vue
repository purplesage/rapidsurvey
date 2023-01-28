<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SurveyForm from "@/Components/SurveyForm.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <AuthenticatedLayout>
        <Head title="create" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Survey
            </h2>
        </template>

        <SurveyForm :isEditing="false" :survey="{}" />
    </AuthenticatedLayout>
</template>
