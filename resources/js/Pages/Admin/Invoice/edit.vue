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
                status: null,
                payment_method: null,
                details: null,
                amount: null,
                order_id: null,
                user_id: null,
            }),
        };
    },
    props: {
        invoice: Object,
    },
    components: {
        InputError,
        InputLabel,
    },
    methods: {
        update() {
            this.form.post(route("admin.invoices.update"), {
                preserveScroll: true,
                onError: (errors) => {
                    console.log(errors);
                },
            });
        },
    },
    mounted() {
        this.form.type =
            this.invoice.typethis.form.status =
            this.invoice.statusthis.form.payment_method =
            this.invoice.payment_methodthis.form.details =
            this.invoice.detailsthis.form.amount =
            this.invoice.amountthis.form.order_id =
            this.invoice.order_idthis.form.user_id =
                this.invoice.user_id;
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
                    <InputLabel
                        for="payment_method"
                        :value="$t('message.payment_method')"
                    />

                    <input
                        type="text"
                        id="payment_method"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.payment_method"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.payment_method"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="details" :value="$t('message.details')" />

                    <textarea
                        id="details"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.details"
                    ></textarea>

                    <InputError class="mt-2" :message="form.errors.details" />
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
                        for="order_id"
                        :value="$t('message.order_id')"
                    />

                    <input
                        type="number"
                        step="0.01"
                        id="order_id"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.order_id"
                    />

                    <InputError class="mt-2" :message="form.errors.order_id" />
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
