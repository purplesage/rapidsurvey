<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
defineProps({
    surveys: Array,
});
</script>

<template>
    <Head title="Surveys" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Created Surveys
                </h2>
                <Link
                    as="button"
                    class="inline-flex items-center gap-2 rounded-md border border-transparent bg-green-600 px-2 py-1 text-xs font-semibold uppercase tracking-wide text-white transition duration-150 ease-in-out hover:bg-green-500 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 sm:px-4 sm:py-2 sm:tracking-widest"
                    :href="route('surveys.create')"
                >
                    <span class="text-xl font-semibold">&plus;</span> Add Survey
                </Link>
            </div>
        </template>

        <main class="py-12">
            <div
                v-if="surveys.length > 0"
                class="mx-auto max-w-2xl sm:px-6 lg:px-8"
            >
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col space-y-5">
                            <div
                                v-for="survey in surveys"
                                :key="survey.id"
                                class="flex flex-col items-center gap-5 rounded-xl border border-gray-200 py-5 shadow-md"
                            >
                                <Link
                                    class="h-2/4 w-1/3 cursor-pointer rounded-xl"
                                    as="button"
                                    :href="
                                        route('survey_answer.create', {
                                            survey: survey.id,
                                        })
                                    "
                                >
                                    <img
                                        class="rounded-xl"
                                        :src="`/storage/${survey.thumbnail}`"
                                        alt="survey thumbnail"
                                    />
                                </Link>

                                <h3
                                    class="text-2xl font-bold tracking-wide md:text-3xl"
                                >
                                    {{ survey.title }}
                                </h3>
                                <p
                                    class="w-2/3 text-justify text-sm text-gray-600 md:text-base"
                                >
                                    {{ survey.description }}
                                </p>
                                <Link
                                    class="inline-flex items-center rounded-lg border border-transparent bg-indigo-500 px-2 py-1 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-600 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
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
            <div
                v-else
                class="h-1/2 p-6 text-center text-4xl text-gray-400 md:text-6xl"
            >
                No surveys created
            </div>
        </main>
    </AuthenticatedLayout>
</template>
