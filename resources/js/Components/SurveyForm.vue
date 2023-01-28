<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Question from "@/Components/Question.vue";
import { useForm, router } from "@inertiajs/vue3";

import { computed, onBeforeMount } from "vue";

const props = defineProps({ survey: Object, isEditing: Boolean });

const addQuestion = (questionObject) => {
    if (!questionObject.id) {
        form.questionList = [...form.questionList, { id: crypto.randomUUID() }];
    }

    form.questionList = form.questionList.map((question) =>
        question.id === questionObject.id ? questionObject : question
    );
};

const deleteQuestion = (id) => {
    form.questionList = form.questionList.filter(
        (question) => question.id !== id
    );
};

const form = useForm({
    title: "",
    description: "",
    thumbnail: "",
    expire_date: "",
    is_active: false,
    questionList: [],
});

onBeforeMount(() => {
    if (props.survey.id) {
        form.title = props.survey.title;
        form.description = props.survey.description;
        form.thumbnail = props.survey.thumbnail;
        form.expire_date = props.survey.expire_date;
        form.is_active = props.survey.is_active;
        form.questionList = JSON.parse(props.survey.questionList);
    }
});

const submit = () => {
    if (props.isEditing) {
        router.post(route("surveys.update", props.survey.id), {
            _method: "put",
            title: form.title,
            description: form.description,
            thumbnail: form.thumbnail,
            expire_date: form.expire_date,
            is_active: form.is_active,
            questionList: form.questionList,
        });
    } else {
        form.post(route("surveys.store"), {
            onFinish: () => form.reset(),
        });
    }
};

const handleImageEdition = computed(() => {
    return (
        typeof form.thumbnail === "string" &&
        form.thumbnail.startsWith("thumbnails/")
    );
});

const imagePreviewUrl = computed(() => {
    try {
        return URL.createObjectURL(form.thumbnail);
    } catch (error) {
        console.error(error);
    }
});
</script>

<template>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="border-gray-200 bg-white overflow-hidden shadow-sm sm:rounded-lg"
            >
                <form @submit.prevent="submit" class="p-6 border">
                    <div>
                        <div
                            class="flex justify-center shadow-md w-fit p-5 rounded-xl mx-auto"
                        >
                            <svg
                                v-if="form.thumbnail.length === 0"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-40 h-40 text-gray-200"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                />
                            </svg>
                            <img
                                class="mb-4"
                                v-else-if="handleImageEdition"
                                :src="`/storage/${form.thumbnail}`"
                                alt="preview image"
                            />
                            <img
                                class="mb-4"
                                v-else
                                :src="imagePreviewUrl"
                                alt="preview image"
                            />
                        </div>

                        <div class="mt-10">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="thumbnail"
                                >Upload Image</label
                            >

                            <input
                                class="file:bg-gray-800 file:border-none file:text-white file:text-sm file:py-2 file:px-4 hover:file:bg-gray-700 file:cursor-pointer block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none"
                                id="thumbnail"
                                type="file"
                                :required="!!isEditing"
                                @change="
                                    (e) => (form.thumbnail = e.target.files[0])
                                "
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.thumbnail"
                            />
                        </div>
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

                        <InputError class="mt-2" :message="form.errors.title" />
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
                            />
                        </div>

                        <InputError
                            class="mt-2"
                            :message="form.errors.is_active"
                        />
                    </div>
                    <div class="mt-10">
                        <hr class="my-10 w-3/4 mx-auto" />

                        <header class="flex items-center justify-between">
                            <h3 class="font-bold text-2xl">Questions</h3>
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                type="button"
                                @click="addQuestion"
                            >
                                Add Question
                            </button>
                        </header>
                        <div class="mb-10">
                            <Question
                                v-for="question in form.questionList"
                                :key="question.id"
                                :questionObject="question"
                                @deleteQuestion="deleteQuestion(question.id)"
                                @addQuestion="
                                    (newQuestionObject) =>
                                        addQuestion(newQuestionObject)
                                "
                            />

                            <p
                                v-if="form.questionList.length < 1"
                                class="text-gray-500"
                            >
                                No questions yet
                            </p>
                        </div>
                    </div>
                    <PrimaryButton>Create</PrimaryButton>
                </form>
            </div>
        </div>
    </div>
</template>
