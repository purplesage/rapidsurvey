<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
defineProps({
    surveys: Array,
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Created Surveys
                </h2>
                <Link
                    class="gap-2 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :href="route('surveys.create')"
                >
                    <span class="font-semibold text-xl">&plus;</span> Add Survey
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col space-y-5">
                            <div
                                v-for="survey in surveys"
                                :key="survey.id"
                                class="border border-gray-200 p-3 rounded-xl shadow-md"
                            >
                                <h3>{{ survey.title }}</h3>
                                <p>{{ survey.description }}</p>
                                <Link
                                    class="inline-flex items-center px-2 py-1 bg-indigo-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase hover:bg-indigo-600 tracking-widest focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    :href="
                                        route('surveys.edit', {
                                            survey: survey.id,
                                        })
                                    "
                                >
                                    &#9998; Edit
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
