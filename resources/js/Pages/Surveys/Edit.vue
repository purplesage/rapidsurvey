<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SurveyForm from "@/Components/SurveyForm.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({ survey: Object });
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.survey?.title }}
            </h2>
            <Link
                method="delete"
                class="inline-flex items-center px-2 py-1 bg-indigo-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase hover:bg-indigo-600 tracking-widest focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                :href="
                    route('surveys.destroy', {
                        survey: survey.id,
                    })
                "
            >
                Delete Survey
            </Link>
            <Link
                class="inline-flex items-center px-2 py-1 bg-indigo-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase hover:bg-indigo-600 tracking-widest focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                :href="
                    route('surveys.show', {
                        survey: survey.id,
                    })
                "
            >
                View Public Link
            </Link>
        </template>

        <SurveyForm :survey="props.survey" :isEditing="true" />
    </AuthenticatedLayout>
</template>
