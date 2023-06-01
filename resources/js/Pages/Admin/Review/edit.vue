<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            form: useForm({
                content: null,
                reply: null,
                user_id: null,
                gig_id: null,
            }),
        };
    },
    props: {
        review: Object,
    },
    components: {
        InputError,
        InputLabel,
    },
    methods: {
        update() {
            this.form.post(route("admin.reviews.update"), {
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                },
            });
        },
    },
    mounted() {
        this.form.content =
            this.review.contentthis.form.reply =
            this.review.replythis.form.user_id =
            this.review.user_idthis.form.gig_id =
                this.review.gig_id;
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="update">
                <div class="mb-4">
                    <InputLabel for="content" :value="$t('message.content')" />

                    <textarea
                        id="content"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.content"
                    ></textarea>

                    <InputError class="mt-2" :message="form.errors.content" />
                </div>

                <div class="mb-4">
                    <InputLabel for="reply" :value="$t('message.reply')" />

                    <textarea
                        id="reply"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.reply"
                    ></textarea>

                    <InputError class="mt-2" :message="form.errors.reply" />
                </div>

                <div class="mb-4">
                    <InputLabel for="user_id" :value="$t('message.user_id')" />

                    <input
                        type="number"
                        step="0.01"
                        id="user_id"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.user_id"
                    />

                    <InputError class="mt-2" :message="form.errors.user_id" />
                </div>

                <div class="mb-4">
                    <InputLabel for="gig_id" :value="$t('message.gig_id')" />

                    <input
                        type="number"
                        step="0.01"
                        id="gig_id"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.gig_id"
                    />

                    <InputError class="mt-2" :message="form.errors.gig_id" />
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
