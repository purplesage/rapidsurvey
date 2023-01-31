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
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ props.survey?.title }}
                </h2>
                <div class="flex gap-5">
                    <Link
                        as="button"
                        class="inline-flex items-center rounded-lg border border-transparent bg-gray-800 px-2 py-1 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-600 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                        :href="
                            route('survey_answer.create', {
                                survey: survey.id,
                            })
                        "
                    >
                        View Public Link
                    </Link>
                    <Link
                        as="button"
                        method="delete"
                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                        :href="
                            route('surveys.destroy', {
                                survey: survey.id,
                            })
                        "
                    >
                        Delete Survey
                    </Link>
                </div>
            </div>
        </template>

        <SurveyForm :survey="props.survey" :isEditing="true" />
    </AuthenticatedLayout>
</template>
