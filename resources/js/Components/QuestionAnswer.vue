<script setup>
const props = defineProps({ QnAobject: Object, model: Object, index: Number });
</script>

<template>
    <div class="flex flex-col items-center gap-2">
        <legend class="space-x-2 text-center text-base font-semibold">
            <span>{{ props.index + 1 }}-.</span
            ><span>{{ QnAobject.title }}</span>
        </legend>
        <p class="text-center text-sm text-gray-500">
            {{ QnAobject.description }}
        </p>
        <div v-if="QnAobject.type === 'text'">
            <input
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                v-model="model.answer"
                required
                placeholder="answer"
                type="text"
            />
            <hr class="my-10 mx-auto w-3/4 border border-gray-300" />
        </div>

        <div v-else-if="QnAobject.type === 'textarea'">
            <textarea
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                v-model="model.answer"
                required
                placeholder="answer"
                type="text"
            ></textarea>
            <hr class="my-10 mx-auto w-3/4 border border-gray-300" />
        </div>

        <div class="mt-5" v-else-if="QnAobject.type === 'checkbox'">
            <fieldset>
                <div
                    class="flex items-center justify-center space-x-3"
                    :key="option.id"
                    v-for="(option, index) of QnAobject.options"
                >
                    <span>{{ option.text }}</span>
                    <input
                        class="border border-gray-300 text-gray-900"
                        v-model="model.answer[index].value"
                        type="checkbox"
                        name="checkbox_answer"
                        :value="option.text"
                    />
                </div>
                <hr class="my-10 mx-auto w-3/4 border border-gray-300" />
            </fieldset>
        </div>

        <div class="mt-5" v-else-if="QnAobject.type === 'radio'">
            <fieldset>
                <div
                    class="space-x-3"
                    :key="option.id"
                    v-for="option in QnAobject.options"
                >
                    <span>{{ option.text }}</span>
                    <input
                        class="border border-gray-300 text-gray-900"
                        v-model="model.answer"
                        type="radio"
                        name="radio_answer"
                        :value="option.text"
                    />
                </div>
            </fieldset>
            <hr class="my-10 mx-auto w-3/4 border border-gray-300" />
        </div>

        <div v-else-if="QnAobject.type === 'select'">
            <select
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-green-100 disabled:text-green-700"
                v-model="model.answer"
                name="option_answer"
                id="option_answer"
            >
                <option :key="option.id" v-for="option in QnAobject.options">
                    {{ option.text }}
                </option>
            </select>
            <hr class="my-10 mx-auto w-3/4 border border-gray-300" />
        </div>
    </div>
</template>
