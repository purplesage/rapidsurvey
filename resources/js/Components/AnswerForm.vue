<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import QuestionAnswer from "@/Components/QuestionAnswer.vue";
import { onBeforeMount, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({ survey: Object });
const questionList = ref([]);

let form;

onBeforeMount(() => {
    questionList.value = [...JSON.parse(props.survey.questionList)];
    const formDefaults = { surveyId: props.survey.id };

    questionList.value.forEach((question, index) => {
        question.type === "checkbox"
            ? (formDefaults[`inputModel_${index}`] = {
                  type: question.type,
                  questionTitle: question.title,
                  answer: question.options.map((option) => ({
                      text: option.text,
                      value: false,
                  })),
              })
            : (formDefaults[`inputModel_${index}`] = {
                  type: question.type,
                  questionTitle: question.title,
                  answer: "",
              });
    });

    form = useForm(formDefaults);
});

const submit = () =>
    form
        .transform((data) => ({
            survey_id: props.survey.id,
            formData: Object.values(data).slice(1),
        }))
        .post(route("survey_answer.store"), {
            onFinish: () => form.reset(),
        });
</script>

<template>
    <div class="bg-gray-300 sm:py-12">
        <div class="mx-auto max-w-4xl sm:rounded-lg sm:px-6 lg:px-8">
            <div
                class="overflow-hidden border-gray-200 bg-white shadow-xl sm:rounded-lg"
            >
                <form
                    @submit.prevent="submit"
                    class="rounded-lg p-5 sm:border-2 sm:border-gray-800 sm:p-10"
                >
                    <header class="flex flex-col gap-10 md:flex-row">
                        <img
                            class="mx-auto h-64 w-3/4 rounded-lg border-2 border-gray-800 md:mx-0 md:w-2/6"
                            :src="`/storage/${props.survey.thumbnail}`"
                            alt="preview image"
                        />

                        <div class="space-y-8">
                            <h1
                                class="text-center text-3xl font-bold md:text-left md:text-5xl md:underline"
                            >
                                {{ props.survey.title }}
                            </h1>
                            <p class="text-justify text-base text-gray-600">
                                {{ props.survey.description }}
                            </p>
                        </div>
                    </header>

                    <section class="mt-10">
                        <hr
                            class="my-10 mx-auto w-3/4 border border-gray-300"
                        />
                        <header class="flex items-center justify-between">
                            <h3 class="mb-5 text-2xl font-bold">Questions</h3>
                        </header>
                        <div class="mb-10 space-y-5">
                            <QuestionAnswer
                                v-for="(QnAobject, index) in questionList"
                                :QnAobject="QnAobject"
                                :model="form[`inputModel_${index}`]"
                                :key="QnAobject.id"
                                :index="index"
                            />
                        </div>
                    </section>
                    <PrimaryButton>Answer</PrimaryButton>
                </form>
            </div>
        </div>
    </div>
</template>
