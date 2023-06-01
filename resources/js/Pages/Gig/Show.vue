<script setup>
import { Link } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
    categories: Object,
    prices: Object,
    times: Object,
    extras_prices: Object,
    extras_times: Object,
    gig: Object,
});
</script>

<template>
    <NavBar class="mb-10" :categories="categories" />

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
                    <li class="inline-flex items-center">
                        <a
                            href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                        >
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
                            عرض الخدمة
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <table
                    class="w-full text-sm text-right text-gray-500 dark:text-gray-400 bg-white"
                >
                    <tr>
                        <th class="px-6 py-3">عنوان الخدمة</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.title"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">الحالة</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.tr_status"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">الوصف</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.description"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">تعليمات للمشتري</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.instructions"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">الصور</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                        >
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                            >
                                <img
                                    v-for="image in gig.thumbnails"
                                    :src="'/storage/images/gigs/' + image"
                                    class="h-52 w-full rounded-md"
                                />
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">مدة التنفيذ</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.time_formated"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">السعر</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.price_formated"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">تغييرات المستخدم</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.user_changes"
                        ></th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3">التصنيف</th>
                        <th
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white"
                            v-text="gig.category.name"
                        ></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <Footer />
</template>
