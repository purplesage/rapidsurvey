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
            v-else-if="QnAobject.type === 'select'"
        >
            <h3>{{ QnAobject.title }}</h3>
            <p>{{ QnAobject.description }}</p>
            <select name="" id="">
                <option v-for="option in QnAobject.options" value="">
                    {{ option.text }}
                </option>
            </select>
        </div>
    </div>
</template>
