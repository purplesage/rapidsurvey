<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({ surveys: Array });

const lastSurvey = props?.surveys[props.surveys.length - 1];
const totalAnswers = props?.surveys.reduce(
    (sum, current) => current.answer.length + sum,
    0
);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div
                class="mx-auto max-w-7xl sm:px-6 lg:px-8"
                v-if="surveys.length > 0"
            >
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div
                        class="flex flex-grow-0 flex-col gap-5 bg-gray-200 p-6 text-gray-900 shadow-2xl md:flex-row md:justify-evenly md:gap-0"
                    >
                        <div
                            class="flex flex-col items-center justify-center rounded-xl border-2 border-gray-900 bg-white p-12 shadow-lg"
                        >
                            <h3 class="text-3xl font-bold">Total Surveys:</h3>
                            <span class="mt-10 text-6xl font-bold">{{
                                surveys.length
                            }}</span>
                        </div>

                        <Link
                            class="w-fit"
                            :href="
                                route('surveys.edit', {
                                    survey: lastSurvey?.id,
                                })
                            "
                        >
                            <div
                                class="flex flex-col items-center gap-8 rounded-xl border-2 border-gray-900 bg-white p-6 shadow-lg"
                            >
                                <h3 class="text-3xl font-bold">
                                    Latest Survey:
                                </h3>

                                <img
                                    class="h-3/4 w-2/3 rounded-xl border-2 border-gray-900"
                                    :src="`/storage/${lastSurvey.thumbnail}`"
                                    alt="preview image"
                                />
                                <p class="font-bold">{{ lastSurvey.title }}</p>
                            </div>
                        </Link>

                        <div
                            class="flex flex-col items-center justify-center rounded-xl border-2 border-gray-900 bg-white p-12 shadow-lg"
                        >
                            <h3 class="text-3xl font-bold">Total Answers:</h3>
                            <span class="mt-10 text-6xl font-bold">
                                {{ totalAnswers }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="h-1/2 p-6 text-center text-6xl text-gray-400">
                No surveys created
            </div>
        </div>
    </AuthenticatedLayout>
</template>
