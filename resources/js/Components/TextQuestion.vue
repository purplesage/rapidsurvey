<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";

const props = defineProps({
    questionID: String,
    unrenderquestion: Function,
});
const emits = defineEmits(["unrenderQuestion", "addQuestion"]);

const questionRef = ref({ title: "", description: "" });
const textQuestionObject = () => {
    return {
        title: questionRef.value.title,
        description: questionRef.value.description,
    };
};
</script>
<template>
    <div class="mt-4">
        <div class="flex space-x-3">
            <button
                type="button"
                @click="emits('addQuestion', textQuestionObject())"
            >
                add
            </button>
            <button type="button" @click="emits('unrenderQuestion')">
                delete
            </button>
        </div>

        <InputLabel for="questionTitle" value="Title" />
        <TextInput
            v-model="questionRef.title"
            id="questionTitle"
            type="text"
            class="mt-1 block w-full"
            required
        />
        <div class="mt-4">
            <InputLabel for="questionDescription" value="Description" />
            <TextInput
                v-model="questionRef.description"
                id="questionDescription"
                type="text"
                class="mt-1 block w-full"
                required
            />
        </div>
        <!-- <div v-if="errors.questionTitle">{{ errors.questionTitle }}</div>
        <div v-if="errors.questionDescription">
            {{ errors.questionDescription }}
        </div> -->

        <!-- <InputError class="mt-2" :message="form.errors.title" /> -->
    </div>
</template>
