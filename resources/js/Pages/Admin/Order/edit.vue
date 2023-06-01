<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            form: useForm({
                status: null,
                amount: null,
                delivery_at: null,
                user_id: null,
                gig_id: null,
            }),
        };
    },
    props: {
        order: Object,
    },
    components: {
        InputError,
        InputLabel,
    },
    methods: {
        update() {
            this.form.post(route("admin.orders.update"), {
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                },
            });
        },
    },
    mounted() {
        this.form.status =
            this.order.statusthis.form.amount =
            this.order.amountthis.form.delivery_at =
            this.order.delivery_atthis.form.user_id =
            this.order.user_idthis.form.gig_id =
                this.order.gig_id;
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="update">
                <div class="mb-4">
                    <InputLabel for="status" :value="$t('message.status')" />

                    <input
                        type="text"
                        id="status"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.status"
                    />

                    <InputError class="mt-2" :message="form.errors.status" />
                </div>

                <div class="mb-4">
                    <InputLabel for="amount" :value="$t('message.amount')" />

                    <input
                        type="number"
                        step="0.01"
                        id="amount"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.amount"
                    />

                    <InputError class="mt-2" :message="form.errors.amount" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="delivery_at"
                        :value="$t('message.delivery_at')"
                    />

                    <input
                        type="text"
                        id="delivery_at"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.delivery_at"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.delivery_at"
                    />
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
