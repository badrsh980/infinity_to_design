<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            form: useForm({
                name: null,
                email: null,
                subject: null,
                message: null,
                readed: null,
            }),
        };
    },
    props: {
        message: Object,
    },
    components: {
        InputError,
        InputLabel,
    },
    methods: {
        update() {
            this.form.post(route("admin.messages.update"), {
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                },
            });
        },
    },
    mounted() {
        this.form.name =
            this.message.namethis.form.email =
            this.message.emailthis.form.subject =
            this.message.subjectthis.form.message =
            this.message.messagethis.form.readed =
                this.message.readed;
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="update">
                <div class="mb-4">
                    <InputLabel for="name" :value="$t('message.name')" />

                    <input
                        type="text"
                        id="name"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" :value="$t('message.email')" />

                    <input
                        type="text"
                        id="email"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.email"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mb-4">
                    <InputLabel for="subject" :value="$t('message.subject')" />

                    <input
                        type="text"
                        id="subject"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.subject"
                    />

                    <InputError class="mt-2" :message="form.errors.subject" />
                </div>

                <div class="mb-4">
                    <InputLabel for="message" :value="$t('message.message')" />

                    <textarea
                        id="message"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.message"
                    ></textarea>

                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <div class="mb-4">
                    <InputLabel for="readed" :value="$t('message.readed')" />

                    <input
                        type="text"
                        id="readed"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.readed"
                    />

                    <InputError class="mt-2" :message="form.errors.readed" />
                </div>

                <div class="mb-4">
                    <button
                        class="py-2 px-4 border bg-primary-light text-white"
                    >
                        <span>{{ $t("message.submit") }}</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
