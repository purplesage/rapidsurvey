<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";

const props = defineProps({ survey: Object });

const form = useForm({
    title: props.survey.title,
    description: props.survey.description,
    // image: {},
});

const submit = () => {
    form.put(route("surveys.update", props.survey.id), {
        onFinish: () => form.reset("title", "description"),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ props.survey.title }}
                </h2>
                <div class="flex items-center space-x-8">
                    <Link
                        :href="
                            route('surveys.show', { survey: props.survey.id })
                        "
                        as="button"
                    >
                        View public link</Link
                    >
                    <Link
                        :href="
                            route('surveys.destroy', {
                                survey: props.survey.id,
                            })
                        "
                        method="delete"
                        as="button"
                    >
                        Delete Survey</Link
                    >
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border-gray-200 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <form @submit.prevent="submit" class="p-6 border">
                        <!-- <div class="mt-4">
                            <InputLabel for="image" value="Image" />
                            <TextInput
                                id="image"
                                type="file"
                                class="mt-1 block w-full"
                                v-model="form.image"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div> -->
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.title"
                            />
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
                        <PrimaryButton class="mt-5">Edit</PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
