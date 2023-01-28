<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Option from "@/Components/Option.vue";
import { ref } from "vue";

const props = defineProps({
    questionID: String,
    unrenderquestion: Function,
});
const emits = defineEmits(["unrenderQuestion", "addQuestion"]);

const renderedOptions = ref([]);

const renderOption = () => {
    renderedOptions.value = [
        ...renderedOptions.value,
        { id: crypto.randomUUID() },
    ];
};

const unrenderOption = (id) => {
    renderedOptions.value = renderedOptions.value.filter(
        (option) => option.id !== id
    );
};

const addOption = (optionObject) => {
    questionRef.value.options = [...questionRef.value.options, optionObject];
};

const questionRef = ref({
    title: "",
    description: "",
    type: "text",
    options: [],
});
const questionObject = () => {
    return {
        id: crypto.randomUUID(),
        title: questionRef.value.title,
        description: questionRef.value.description,
        type: questionRef.value.type,
        options: questionRef.value.options,
    };
};

const disabled = ref(false);
</script>
<template>
    <div class="mt-4">
        <div class="space-x-5">
            <label for="question_type">Question type:</label>
            <select
                v-model="questionRef.type"
                name="question_type"
                id="question_type"
                :disabled="disabled"
            >
                <option value="text">Text</option>
                <option value="select">Select</option>
                <option value="radio">Radio</option>
                <option value="checkbox">Checkbox</option>
                <option value="textarea">Textarea</option>
            </select>
        </div>
        <!-- text question -->
        <div v-if="questionRef.type === 'text'">
            <div class="flex space-x-3 mt-5">
                <button
                    :disabled="disabled"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
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
                <button
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    type="button"
                    @click="emits('unrenderQuestion')"
                >
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
                :disabled="disabled"
            />
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
        <!-- select question -->
        <div
            v-else-if="
                questionRef.type === 'checkbox' ||
                questionRef.type === 'select' ||
                questionRef.type === 'radio'
            "
        >
            <div class="flex space-x-3 mt-5">
                <button
                    type="button"
                    @click="emits('addQuestion', questionObject())"
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
            <div class="mt-5">
                <div class="flex justify-between">
                    <h3>Options</h3>
                    <button type="button" @click="renderOption">
                        add option
                    </button>
                </div>
                <Option
                    v-for="option in renderedOptions"
                    :key="option.id"
                    @unrenderOption="unrenderOption(option.id)"
                    @addOption="(optionObject) => addOption(optionObject)"
                />
            </div>
        </div>
    </div>
</template>
