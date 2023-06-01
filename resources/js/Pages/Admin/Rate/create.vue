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
                count: null,
                review_id: null,
                gig_id: null,
            }),
        };
    },
    props: {},
    components: {
        InputError,
        InputLabel,
    },
    methods: {
        create() {
            this.form.post(route("admin.rates.store"), {
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                },
            });
        },
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="create">
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
                    <InputLabel for="count" :value="$t('message.count')" />

                    <input
                        type="number"
                        step="0.01"
                        id="count"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.count"
                    />

                    <InputError class="mt-2" :message="form.errors.count" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="review_id"
                        :value="$t('message.review_id')"
                    />

                    <input
                        type="number"
                        step="0.01"
                        id="review_id"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.review_id"
                    />

                    <InputError class="mt-2" :message="form.errors.review_id" />
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
