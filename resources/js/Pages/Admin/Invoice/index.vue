<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        invoices: Object,
    },
    components: {
        AdminLayout,
        Footer,
        Link,
    },
    methods: {
        delete(id) {
            router.delete(route("admin.invoices.destroy", { invoice: id }));
        },
    },
};
</script>

<template>
    <AdminLayout>
        <div class="mt-12 p-6 bg-gray-50">
            <div class="my-6 flex justify-between items-center">
                <div></div>
                <div>
                    <a class="p-4 font-normal text-base bg-primary-light text-white" :href="route('admin.invoices.create')">{{ $t('message.add') }}</a>
                </div>
            </div>
            <div class="my-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">{{ $t("message.type") }}</th>
<th scope="col" class="px-6 py-3">{{ $t("message.status") }}</th>
<th scope="col" class="px-6 py-3">{{ $t("message.payment_method") }}</th>
<th scope="col" class="px-6 py-3">{{ $t("message.details") }}</th>
<th scope="col" class="px-6 py-3">{{ $t("message.amount") }}</th>
<th scope="col" class="px-6 py-3">{{ $t("message.order_id") }}</th>
<th scope="col" class="px-6 py-3">{{ $t("message.user_id") }}</th>

                                <th scope="col" class="px-6 py-3">{{ $t('message.options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="invoice in invoices"
                            >
                                <td class="px-6 py-4" v-text="invoice.type"></td>
<td class="px-6 py-4" v-text="invoice.status"></td>
<td class="px-6 py-4" v-text="invoice.payment_method"></td>
<td class="px-6 py-4" v-text="invoice.details"></td>
<td class="px-6 py-4" v-text="invoice.amount"></td>
<td class="px-6 py-4" v-text="invoice.order_id"></td>
<td class="px-6 py-4" v-text="invoice.user_id"></td>

                                <td class="px-6 py-4">
                                    <a
                                        :href="
                                            route('admin.invoices.edit', {
                                                invoice: invoice.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t('message.edit') }}</a
                                    >
                                    <a
                                        :href="
                                            route('admin.invoices.show', {
                                                invoice: invoice.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t('message.show') }}</a
                                    >
                                    <button
                                        type="button"
                                        @click="delete(invoice.id)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        {{ $t('message.delete') }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <nav
                        class="flex items-center justify-between pt-4"
                        aria-label="Table navigation"
                    >
                        <span
                            class="text-sm font-normal text-gray-500 dark:text-gray-400"
                            >Showing
                            <span
                                class="font-semibold text-gray-900 dark:text-white"
                                >1-10</span
                            >
                            of
                            <span
                                class="font-semibold text-gray-900 dark:text-white"
                                >1000</span
                            ></span
                        >
                        <ul class="inline-flex items-center -space-x-px">
                            <li>
                                <a
                                    href="#"
                                    class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                >
                                    <span class="sr-only">Previous</span>
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    >1</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    >2</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    aria-current="page"
                                    class="z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                                    >3</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    >...</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    >100</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                >
                                    <span class="sr-only">Next</span>
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav> -->
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
