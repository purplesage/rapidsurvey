<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextQuestion from "@/Components/TextQuestion.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const renderedQuestions = ref([]);

const renderQuestion = () => {
    renderedQuestions.value = [
        ...renderedQuestions.value,
        { id: crypto.randomUUID() },
    ];
};

const unrenderQuestion = (id) => {
    renderedQuestions.value = renderedQuestions.value.filter(
        (question) => question.id !== id
    );
};

const addQuestion = (questionObject) => {
    questionList.value = [...questionList.value, questionObject];
};

const questionList = ref([]);

const form = useForm({
    title: "",
    description: "",
    thumbnail: "",
    expire_date: "",
    is_active: false,
    questionList,
});

const submit = () => {
    form.post(route("surveys.store"), {
        onFinish: () => form.reset("title", "description"),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Survey
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border-gray-200 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <form @submit.prevent="submit" class="p-6 border">
                        <div>
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="thumbnail"
                                >Upload file</label
                            >
                            <input
                                class="file:bg-gray-800 file:border-none file:text-white file:text-sm file:py-2 file:px-4 hover:file:bg-gray-700 file:cursor-pointer block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none"
                                id="thumbnail"
                                type="file"
                                required
                                @change="
                                    (e) => (form.thumbnail = e.target.files[0])
                                "
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.thumbnail"
                            />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.title"
                            />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />
                            <TextInput
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div>
                        <div class="mt-5">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="expire_date"
                                >Expire date</label
                            >
                            <input
                                class="file:bg-gray-800 file:border-none file:text-white file:text-sm file:py-2 file:px-4 hover:file:bg-gray-700 file:cursor-pointer block w-1/6 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none"
                                id="expire_date"
                                type="date"
                                v-model="form.expire_date"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.expire_date"
                            />
                        </div>
                        <div class="mt-5">
                            <div class="flex space-x-3">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="is_active"
                                    >Active</label
                                >
                                <input
                                    class="block text-sm text-gray-800 bordercursor-pointer focus:outline-none"
                                    id="is_active"
                                    type="checkbox"
                                    :checked="form.is_active"
                                    v-model="form.is_active"
                                    required
                                />
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.expire_date"
                            />
                        </div>
                        <div class="mt-10">
                            <header class="flex items-center justify-between">
                                <h3 class="font-bold text-xl">Questions</h3>
                                <button type="button" @click="renderQuestion">
                                    Add Question
                                </button>
                            </header>
                            <div>
                                <TextQuestion
                                    v-for="question in renderedQuestions"
                                    :key="question.id"
                                    @unrenderQuestion="
                                        unrenderQuestion(question.id)
                                    "
                                    @addQuestion="
                                        (questionObject) =>
                                            addQuestion(questionObject)
                                    "
                                />

                                <p
                                    v-if="renderedQuestions.length < 1"
                                    class="text-gray-500"
                                >
                                    No questions yet
                                </p>
                            </div>
                        </div>
                        <PrimaryButton class="mt-5">Create</PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
