<script setup>
import { Link, router } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";

const formatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
});

defineProps({
    categories: Object,
    balance: Number,
    pending_balance: Number,
    all: Number,
    user: Object,
});

function withdraw() {
    router.post(route("credit"), {
        page: "withdraw",
    });
}
</script>
<template>
    <NavBar :categories="categories" />

    <div class="mt-12 p-6 bg-gray-50">
        <div class="max-w-screen-xl mx-auto">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a
                            href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-4 h-4 mx-2"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                                ></path>
                            </svg>
                            الصفحة الرئيسية
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg
                                aria-hidden="true"
                                class="w-6 h-6 text-gray-400 rotate-180"
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
                            رصيدي
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div
                    class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-full md:w-3/4 mx-auto bg-white"
                >
                    <div class="text-center p-6">
                        <div class="text-xl my-2">الرصيد الكلي</div>
                        <div
                            class="text-2xl my-2 text-primary-light font-bold"
                            v-text="formatter.format(all)"
                        ></div>
                        <div class="text-sm my-2">
                            كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح
                            والرصيد المعلّق أيضاً.
                        </div>
                    </div>
                    <div class="text-center p-6">
                        <div class="text-xl my-2">رصيد معلّق</div>
                        <div
                            class="text-2xl my-2 text-primary-light font-bold"
                            v-text="formatter.format(pending_balance)"
                        ></div>
                        <div class="text-sm my-2">
                            يتم تعليق الأرباح التي حققتها لمدة 14 يوم قبل أن
                            تتمكن من استخدامها.
                        </div>
                    </div>
                    <div class="text-center p-6">
                        <div class="text-xl my-2">أرباح يمكن سحبها</div>
                        <div
                            class="text-2xl my-2 text-primary-light font-bold"
                            v-text="formatter.format(balance)"
                        ></div>
                        <div class="text-sm my-2">
                            المبلغ الذي حققته من بيع الخدمات ويمكن سحبه الى
                            حسابك البنكي
                        </div>
                    </div>
                </div>

                <div
                    class="gap-4 w-full md:w-3/4 mx-auto bg-white my-6 md:p-6 flex justify-center items-center"
                    v-if="balance > 5"
                >
                    <button
                        type="button"
                        @click="withdraw()"
                        class="text-white bg-primary-light hover:bg-primary-dark duration-100 font-medium rounded-sm text-base px-5 py-2.5"
                    >
                        سحب الأرباح
                    </button>
                </div>

                <div class="bg-white my-4 w-full md:w-3/4 mx-auto">
                    <div
                        class="p-4 border-b border-b-gray-100 text-xl font-bold"
                    >
                        معاملاتي المالية
                    </div>
                    <div class="">
                        <div class="relative overflow-x-auto">
                            <table
                                class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 rounded-l-lg"
                                        >
                                            نوع المعاملة
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 rounded-l-lg"
                                        >
                                            الحالة
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            طريقة الدفع
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 rounded-r-lg"
                                        >
                                            السعر
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 rounded-r-lg"
                                        >
                                            التاريخ
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="bg-white dark:bg-gray-800"
                                        v-for="invoice in user.invoices"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            v-text="invoice.tr_type"
                                        ></th>
                                        <td
                                            class="px-6 py-4"
                                            v-text="invoice.tr_status"
                                        ></td>
                                        <td
                                            class="px-6 py-4"
                                            v-text="invoice.method"
                                        ></td>
                                        <td
                                            class="px-6 py-4"
                                            v-text="invoice.amount"
                                        ></td>
                                        <td
                                            class="px-6 py-4"
                                            v-text="invoice.created_date"
                                        ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
