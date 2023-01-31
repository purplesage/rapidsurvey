<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import QuestionAnswer from "@/Components/QuestionAnswer.vue";
import { onBeforeMount, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({ survey: Object });
const questionList = ref([]);

const form = useForm({});

onBeforeMount(() => {
    questionList.value = [...JSON.parse(props.survey.questionList)];
    questionList.value.forEach(
        (question, index) =>
            (form[`inputModel_${index}`] = {
                surveyId: props.survey.id,
                questionTitle: question.title,
                answer: "",
            })
    );
});

const submit = form.post(route("surveys.store"), {
    onFinish: () => form.reset(),
});
</script>

<template>
    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div
                class="overflow-hidden border-gray-200 bg-white shadow-xl sm:rounded-lg"
            >
                <form
                    @submit.prevent="submit"
                    class="rounded-lg border-2 border-gray-800 p-10"
                >
                    <header class="flex gap-10">
                        <img
                            class="h-64 w-2/6 rounded-lg border-2 border-gray-800"
                            :src="`/storage/${props.survey.thumbnail}`"
                            alt="preview image"
                        />

                        <div class="space-y-8">
                            <h1 class="text-5xl font-bold underline">
                                {{ props.survey.title }}
                            </h1>
                            <p class="text-justify text-base text-gray-600">
                                {{ props.survey.description }}
                            </p>
                        </div>
                    </header>

                    <section class="mt-10">
                        <hr class="my-10 mx-auto w-3/4" />
                        <header class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold">Questions header</h3>
                        </header>
                        <div class="mb-10">
                            <QuestionAnswer
                                v-for="(QnAobject, index) in questionList"
                                :QnAobject="QnAobject"
                                :model="form[`inputModel_${index}`]"
                                :key="QnAobject.id"
                            />
                        </div>
                    </section>
                    <PrimaryButton>Answer</PrimaryButton>
                </form>
            </div>
        </div>
    </div>
</template>
