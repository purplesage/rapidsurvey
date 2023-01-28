<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Option from "@/Components/Option.vue";
import { ref, computed } from "vue";

const props = defineProps({
    questionID: String,
    unrenderquestion: Function,
});
const emits = defineEmits(["deleteQuestion", "addQuestion"]);

const addOption = (optionObject) => {
    if (!optionObject.id) {
        questionRef.value.options = [
            ...questionRef.value.options,
            { id: crypto.randomUUID() },
        ];
    }

    questionRef.value.options = questionRef.value.options.map((option) =>
        option.id === optionObject.id ? questionObject : option
    );
};

const deleteOption = (id) => {
    questionRef.value.options = questionRef.value.options.filter(
        (option) => option.id !== id
    );
};

const questionRef = ref({
    title: "",
    description: "",
    type: "text",
    options: [],
});

const questionObject = () => {
    return {
        id: props.questionID,
        title: questionRef.value.title,
        description: questionRef.value.description,
        type: questionRef.value.type,
        options: questionRef.value.options,
    };
};

const deleteAllOptions = () => {
    questionRef.value.options = [];
};

const canUseAddButton = computed(() => {
    const simpleInputs = ["text", "textarea"];

    if (simpleInputs.includes(questionRef.value.type)) {
        return questionRef.value.title?.length > 0;
    } else {
        return (
            questionRef.value.title.length > 0 &&
            questionRef.value.options.length > 0
        );
    }
});

//todo: inputsAreDisabled --rename--
const disabled = ref(false);
</script>
<template>
    <div class="mt-10">
        <div class="space-x-5">
            <label for="question_type">Question type:</label>
            <select
                class="text-sm rounded-lg"
                v-model="questionRef.type"
                name="question_type"
                id="question_type"
                :disabled="disabled"
                @change="deleteAllOptions"
            >
                <option value="text">Text</option>
                <option value="select">Select</option>
                <option value="radio">Radio</option>
                <option value="checkbox">Checkbox</option>
                <option value="textarea">Textarea</option>
            </select>
        </div>
        <!-- text question -->
        <div class="mt-10">
            <div class="flex space-x-3 mt-5">
                <button
                    v-if="canUseAddButton"
                    :disabled="disabled"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:bg-green-200 disabled:text-slate-600 disabled:font-semibold"
                    type="button"
                    @click="
                        () => {
                            emits('addQuestion', questionObject());
                            disabled = true;
                        }
                    "
                >
                    {{ disabled ? "added" : "add" }}
                </button>
                <div
                    class="inline-flex items-center px-4 py-2 bg-green-200 border border-transparent rounded-md font-semibold text-slate-500 text-xs cursor-not-allowed uppercase tracking-widest"
                    v-else
                >
                    add
                </div>
                <button
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    type="button"
                    @click="emits('deleteQuestion')"
                >
                    delete
                </button>
            </div>
            <div
                v-if="
                    questionRef.type === 'text' ||
                    questionRef.type === 'textarea'
                "
            >
                <div class="mt-4">
                    <InputLabel for="questionTitle" value="Title" />
                    <TextInput
                        v-model="questionRef.title"
                        id="questionTitle"
                        type="text"
                        class="mt-1 block w-full disabled:bg-green-100 disabled:text-green-700"
                        required
                        :disabled="disabled"
                    />
                </div>
                <div class="mt-4">
                    <InputLabel for="questionDescription" value="Description" />
                    <TextInput
                        v-model="questionRef.description"
                        id="questionDescription"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        :disabled="disabled"
                    />
                </div>
            </div>
            <!-- Questions with options -->
            <div
                class="mt-10"
                v-else-if="
                    questionRef.type === 'checkbox' ||
                    questionRef.type === 'select' ||
                    questionRef.type === 'radio'
                "
            >
                <div class="mt-5">
                    <InputLabel for="questionTitle" value="Title" />
                    <TextInput
                        :disabled="disabled"
                        v-model="questionRef.title"
                        id="questionTitle"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                </div>
                <div class="mt-4">
                    <InputLabel for="questionDescription" value="Description" />
                    <TextInput
                        :disabled="disabled"
                        v-model="questionRef.description"
                        id="questionDescription"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                </div>
                <div class="mt-10">
                    <div class="flex justify-between">
                        <h3 class="font-bold text-xl">Options</h3>
                        <button
                            :disabled="disabled"
                            type="button"
                            @click="addOption"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:bg-gray-500 disabled:cursor-not-allowed"
                        >
                            Add Option
                        </button>
                    </div>
                    <div class="mt-5 space-y-5">
                        <Option
                            :disabled="disabled"
                            v-for="(option, index) in questionRef.options"
                            :key="option.id"
                            :index="index"
                            @deleteOption="deleteOption(option.id)"
                            @addOption="
                                (optionObject) => addOption(optionObject)
                            "
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-20 w-1/2 mx-auto border border-slate-300" />
</template>
