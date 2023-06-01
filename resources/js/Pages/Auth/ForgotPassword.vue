<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <NavBar />

    <div
        class="w-full mx-2 lg:w-1/2 min-h-screen lg:mx-auto flex justify-center items-center flex-col"
    >
        <div class="mb-4 text-sm text-gray-600">
            هل نسيت كلمة السر، لا تقلق أكتب فقط بريدك الالكتروني ونحن سنرسل لك
            رابط في بريدك الإلكتروني لإعادة الكلمة السر الخاصة بك
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form
            @submit.prevent="submit"
            class="w-full bg-white rounded-md shadow-md p-6"
        >
            <div>
                <InputLabel for="email" value="البريد الإلكتروني" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-start mt-4">
                <PrimaryButton
                    class="bg-primary-dark"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    إرسال الرابط
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
