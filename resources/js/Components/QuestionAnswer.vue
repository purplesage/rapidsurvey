<script setup>
const props = defineProps({ QnAobject: Object, model: Object });
</script>

<template>
    <div>
        <div
            class="border-2 border-gray-500 p-3"
            v-if="QnAobject.type === 'text'"
        >
            <h3>{{ QnAobject.title }}</h3>
            <p>{{ QnAobject.description }}</p>
            <input
                v-model="model.answer"
                required
                placeholder="answer"
                type="text"
            />
        </div>

        <div
            class="border-2 border-gray-500 p-3"
            v-else-if="QnAobject.type === 'textarea'"
        >
            <h3>{{ QnAobject.title }}</h3>
            <p>{{ QnAobject.description }}</p>
            <textarea
                v-model="model.answer"
                required
                placeholder="answer"
                type="text"
            ></textarea>
        </div>

        <div
            class="border-2 border-gray-500 p-3"
            v-else-if="QnAobject.type === 'checkbox'"
        >
            <legend>{{ QnAobject.title }}</legend>
            <p>{{ QnAobject.description }}</p>
            <fieldset>
                <div
                    :key="option.id"
                    v-for="(option, index) of QnAobject.options"
                >
                    <span>{{ option.text }}</span>
                    <input
                        v-model="model.answer[index].value"
                        type="checkbox"
                        name="checkbox_answer"
                        :value="option.text"
                    />
                </div>
            </fieldset>
        </div>

        <div
            class="border-2 border-gray-500 p-3"
            v-else-if="QnAobject.type === 'radio'"
        >
            <legend>{{ QnAobject.title }}</legend>
            <p>{{ QnAobject.description }}</p>
            <fieldset>
                <div :key="option.id" v-for="option in QnAobject.options">
                    <span>{{ option.text }}</span>
                    <input
                        v-model="model.answer"
                        type="radio"
                        name="radio_answer"
                        :value="option.text"
                    />
                </div>
            </fieldset>
        </div>

        <div
            class="border-2 border-gray-500 p-3"
            v-else-if="QnAobject.type === 'select'"
        >
            <h3>{{ QnAobject.title }}</h3>
            <p>{{ QnAobject.description }}</p>
            <select
                v-model="model.answer"
                name="option_answer"
                id="option_answer"
            >
                <option :key="option.id" v-for="option in QnAobject.options">
                    {{ option.text }}
                </option>
            </select>
        </div>
    </div>
</template>
