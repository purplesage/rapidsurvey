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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ props.survey?.title }}
                </h2>
                <div class="flex gap-5">
                    <Link
                        as="button"
                        class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase hover:bg-indigo-600 tracking-widest focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        :href="
                            route('surveys.show', {
                                survey: survey.id,
                            })
                        "
                    >
                        View Public Link
                    </Link>
                    <Link
                        as="button"
                        method="delete"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
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
