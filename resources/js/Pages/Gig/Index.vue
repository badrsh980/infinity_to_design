<script>
import { Link, router } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";

export default {
    props: {
        categories: Object,
        gigs: Object,
    },
    components: {
        NavBar,
        Footer,
        Link,
    },
    methods: {
        deleteGig(id) {
            router.delete(route("gigs.destroy", { gig: id }));
        },
    },
};
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
                            :href="route('gigs.index')"
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
                            خدماتي
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-white uppercase bg-primary-light"
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
                                <th scope="col" class="px-6 py-3">التصنيف</th>
                                <th scope="col" class="px-6 py-3">
                                    مدة التنفيذ
                                </th>
                                <th scope="col" class="px-6 py-3">الخيارات</th>
                            </tr>
                        </thead>
                        <tbody v-if="gigs.length > 0">
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="gig in gigs"
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
                                    v-text="gig.id"
                                ></th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    v-text="gig.title"
                                ></th>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.tr_status"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.price_formated"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.category.name"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.time_formated"
                                ></td>
                                <td class="px-6 py-4">
                                    <a
                                        :href="
                                            route('gigs.edit', {
                                                gig: gig.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >تعديل</a
                                    >
                                    <a
                                        :href="
                                            route('gigs.show', {
                                                gig: gig.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >عرض</a
                                    >
                                    <button
                                        type="button"
                                        @click="deleteGig(gig.id)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        حذف
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <th
                                    colspan="10"
                                    scope="col"
                                    class="px-6 py-3 bg-white"
                                >
                                    لا توجد لديك أية خدمات
                                </th>
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
    </div>

    <Footer />
</template>
