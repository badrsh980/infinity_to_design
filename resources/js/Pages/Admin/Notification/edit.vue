<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            form: useForm({
                type: null,
                notifiable_type: null,
                notifiable_id: null,
                data: null,
                read_at: null,
            }),
        };
    },
    props: {
        notification: Object,
    },
    components: {
        InputError,
        InputLabel,
    },
    methods: {
        update() {
            this.form.post(route("admin.notifications.update"), {
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                },
            });
        },
    },
    mounted() {
        this.form.type =
            this.notification.typethis.form.notifiable_type =
            this.notification.notifiable_typethis.form.notifiable_id =
            this.notification.notifiable_idthis.form.data =
            this.notification.datathis.form.read_at =
                this.notification.read_at;
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="update">
                <div class="mb-4">
                    <InputLabel for="type" :value="$t('message.type')" />

                    <input
                        type="text"
                        id="type"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.type"
                    />

                    <InputError class="mt-2" :message="form.errors.type" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="notifiable_type"
                        :value="$t('message.notifiable_type')"
                    />

                    <input
                        type="text"
                        id="notifiable_type"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.notifiable_type"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.notifiable_type"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="notifiable_id"
                        :value="$t('message.notifiable_id')"
                    />

                    <input
                        type="number"
                        step="0.01"
                        id="notifiable_id"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.notifiable_id"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.notifiable_id"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="data" :value="$t('message.data')" />

                    <textarea
                        id="data"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.data"
                    ></textarea>

                    <InputError class="mt-2" :message="form.errors.data" />
                </div>

                <div class="mb-4">
                    <InputLabel for="read_at" :value="$t('message.read_at')" />

                    <input
                        type="text"
                        id="read_at"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.read_at"
                    />

                    <InputError class="mt-2" :message="form.errors.read_at" />
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
