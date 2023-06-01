<script>
import { Link, router } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";

export default {
    props: {
        categories: Object,
        orders: Object,
    },
    components: { Link, NavBar, Footer },
    methods: {
        changeStatus(id, status) {
            router.post(route("orders.update", { id: id }), {
                status,
            });
        },
        createChat(user_id, order_id) {
            router.post(route("create-chat", { user_id, order_id }));
        },
    },
};
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
                            الطلبيات
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div class="w-full mx-auto bg-white overflow-auto">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs uppercase bg-primary-light text-white"
                        >
                            <tr>
                                <!-- <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input
                                            id="checkbox-all-search"
                                            type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                    </div>
                                </th> -->
                                <th scope="col" class="px-6 py-3">الرمز</th>
                                <th scope="col" class="px-6 py-3">
                                    عنوان الخدمة
                                </th>
                                <th scope="col" class="px-6 py-3">الحالة</th>
                                <th scope="col" class="px-6 py-3">السعر</th>
                                <th scope="col" class="px-6 py-3">المشتري</th>
                                <th scope="col" class="px-6 py-3">
                                    تاريخ التسليم
                                </th>
                                <th scope="col" class="px-6 py-3">الخيارات</th>
                            </tr>
                        </thead>
                        <tbody v-if="orders.length > 0">
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="order in orders"
                            >
                                <!-- <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input
                                            :id="
                                                'checkbox-table-search-' +
                                                gig.id
                                            "
                                            type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                    </div>
                                </td> -->
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    v-text="order.id"
                                ></th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    <Link
                                        :href="
                                            route('gig', {
                                                slug: order.gig.slug,
                                            })
                                        "
                                    >
                                        {{ order.gig.title }}
                                    </Link>
                                </th>
                                <td
                                    class="px-6 py-4"
                                    v-text="order.tr_status"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="order.price_formated"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="order.user.name"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="order.time_formated"
                                ></td>
                                <td class="px-6 py-4">
                                    <button
                                        v-if="order.status == 'active'"
                                        @click.prevent="
                                            changeStatus(order.id, 'reject')
                                        "
                                        type="button"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                    >
                                        إلغاء
                                    </button>
                                    <button
                                        v-if="order.status == 'pending'"
                                        @click.prevent="
                                            changeStatus(order.id, 'activate')
                                        "
                                        type="button"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                    >
                                        تأكيد
                                    </button>
                                    <button
                                        v-if="order.status == 'active'"
                                        @click.prevent="
                                            changeStatus(order.id, 'complete')
                                        "
                                        type="button"
                                        class="font-medium text-orange-600 dark:text-orange-500 hover:underline mx-1"
                                    >
                                        إكمال
                                    </button>
                                    <button
                                        @click.prevent="
                                            createChat(order.user_id, order.id)
                                        "
                                        type="button"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                    >
                                        تواصل مع المشتري
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-white">
                                    ليس لديك أية طلبيات بعد
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
