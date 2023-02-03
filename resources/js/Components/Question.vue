<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Option from "@/Components/Option.vue";
import { ref, onBeforeMount } from "vue";

const props = defineProps({
    questionObject: Object,
});
const emits = defineEmits(["deleteQuestion"]);

const addOption = () => {
    props.questionObject.options = [
        ...props.questionObject.options,
        { id: crypto.randomUUID(), text: "" },
    ];
};

const deleteOption = (id) => {
    props.questionObject.options = props.questionObject.options.filter(
        (option) => option.id !== id
    );
};

const questionRef = ref({
    title: "",
    description: "",
    type: "text",
    options: [],
});

onBeforeMount(() => {
    if (props.questionObject?.hasOwnProperty("title")) {
        questionRef.value.title = props.questionObject.title;
        questionRef.value.description = props.questionObject.description;
        questionRef.value.type = props.questionObject.type;
        questionRef.value.options = props.questionObject.options;
    }
});

const deleteAllOptions = () => {
    props.questionObject.options = [];
};
</script>
<template>
    <div class="mt-10">
        <div class="space-x-5">
            <label for="question_type">Question type:</label>
            <select
                class="rounded-lg text-sm"
                v-model="questionObject.type"
                name="question_type"
                id="question_type"
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
            <div class="mt-5 flex space-x-3">
                <button
                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                    type="button"
                    @click="emits('deleteQuestion')"
                >
                    delete
                </button>
            </div>
            <div
                v-if="
                    questionObject.type === 'text' ||
                    questionObject.type === 'textarea'
                "
            >
                <div class="mt-4">
                    <InputLabel for="questionTitle" value="Title" />
                    <TextInput
                        v-model="questionObject.title"
                        id="questionTitle"
                        type="text"
                        class="mt-1 block w-full disabled:bg-green-100 disabled:text-green-700"
                        required
                    />
                </div>
                <div class="mt-4">
                    <InputLabel for="questionDescription" value="Description" />
                    <TextInput
                        v-model="questionObject.description"
                        id="questionDescription"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                </div>
            </div>
            <!-- Questions with options -->
            <div
                class="mt-10"
                v-else-if="
                    questionObject.type === 'checkbox' ||
                    questionObject.type === 'select' ||
                    questionObject.type === 'radio'
                "
            >
                <div class="mt-5">
                    <InputLabel for="questionTitle" value="Title" />
                    <TextInput
                        v-model="questionObject.title"
                        id="questionTitle"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                </div>
                <div class="mt-4">
                    <InputLabel for="questionDescription" value="Description" />
                    <TextInput
                        v-model="questionObject.description"
                        id="questionDescription"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                </div>
                <div class="mt-10">
                    <div class="flex justify-between">
                        <h3 class="text-xl font-bold">Options</h3>
                        <button
                            type="button"
                            @click="addOption"
                            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 disabled:cursor-not-allowed disabled:bg-gray-500"
                        >
                            Add Option
                        </button>
                    </div>
                    <div class="mt-5 space-y-5">
                        <Option
                            v-for="(option, index) in questionObject.options"
                            :key="option.id"
                            :optionObject="option"
                            :index="index"
                            @deleteOption="deleteOption(option.id)"
                            @addOption="addOption"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-20 mx-auto w-1/2 border border-slate-300" />
</template>

<!-- <script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Option from "@/Components/Option.vue";
import { ref, computed, onBeforeMount } from "vue";

const props = defineProps({
    questionObject: Object,
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
        option.id === optionObject.id ? optionObject : option
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

onBeforeMount(() => {
    if (props.questionObject?.hasOwnProperty("title")) {
        questionRef.value.title = props.questionObject.title;
        questionRef.value.description = props.questionObject.description;
        questionRef.value.type = props.questionObject.type;
        questionRef.value.options = props.questionObject.options;
    }
});

const newQuestionObject = () => {
    return {
        id: props.questionObject.id,
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

const disabled = ref(false);
</script>
<template>
    <div class="mt-10">
        <div class="space-x-5">
            <label for="question_type">Question type:</label>
            <select
                class="rounded-lg text-sm"
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

        <div class="mt-10">
            <div class="mt-5 flex space-x-3">
                <button
                    v-if="canUseAddButton"
                    :disabled="disabled"
                    class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-green-500 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 disabled:bg-green-200 disabled:font-semibold disabled:text-slate-600"
                    type="button"
                    @click="
                        () => {
                            emits('addQuestion', newQuestionObject());
                            disabled = true;
                        }
                    "
                >
                    {{ disabled ? "added" : "add" }}
                </button>
                <div
                    class="inline-flex cursor-not-allowed items-center rounded-md border border-transparent bg-green-200 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-slate-500"
                    v-else
                >
                    add
                </div>
                <button
                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
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
                        <h3 class="text-xl font-bold">Options</h3>
                        <button
                            :disabled="disabled"
                            type="button"
                            @click="addOption"
                            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 disabled:cursor-not-allowed disabled:bg-gray-500"
                        >
                            Add Option
                        </button>
                    </div>
                    <div class="mt-5 space-y-5">
                        <Option
                            :disabled="disabled"
                            v-for="(option, index) in questionRef.options"
                            :key="option.id"
                            :optionObject="option"
                            :index="index"
                            @deleteOption="deleteOption(option.id)"
                            @addOption="
                                (newOptionObject) => addOption(newOptionObject)
                            "
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-20 mx-auto w-1/2 border border-slate-300" />
</template>
 -->
