<script>
import { Link, useForm, router } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import Modal from "@/Components/Modal.vue";

export default {
    data() {
        return {
            // ratings: {},
            // gig_id: null,
            showRate: false,

            form: useForm({
                ratings: {},
                gig_id: null,
                content: null,
            }),
        };
    },
    props: {
        categories: Object,
        orders: Object,
        options: Object,
    },
    components: { Link, NavBar, Footer, Modal },
    methods: {
        changeStatus(id, status) {
            router.post(route("orders.update", { id: id }), {
                status,
            });
        },
        createChat(user_id) {
            router.post(route("create-chat", { user_id }));
        },
        rate() {
            this.form.post(route("orders.rate"), {
                onFinish: () => {
                    this.showRate = false;
                },
            });
        },
        setRate(index, i) {
            this.form.ratings[index] = i;
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
                    <div
                        v-if="$page.props.flash.message"
                        class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert"
                    >
                        {{ $page.props.flash.message }}
                    </div>
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
                                    v-text="order.gig.title"
                                ></th>
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
                                        type="button"
                                        v-if="order.status == 'pending'"
                                        @click="
                                            changeStatus(
                                                puechase.status,
                                                'cancel'
                                            )
                                        "
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        إلغاء
                                    </button>
                                    <button
                                        v-if="order.status == 'completed'"
                                        @click.prevent="
                                            changeStatus(order.id, 'deliver')
                                        "
                                        type="button"
                                        class="font-medium text-orange-600 dark:text-orange-500 hover:underline mx-1"
                                    >
                                        تم التوصيل
                                    </button>
                                    <button
                                        type="button"
                                        v-if="
                                            order.gig.review == 0 &&
                                            order.status == 'delivered'
                                        "
                                        @click.prevent="
                                            form.gig_id = order.gig.id;
                                            showRate = true;
                                        "
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline mx-1"
                                    >
                                        تقييم
                                    </button>
                                    <button
                                        @click.prevent="
                                            createChat(order.gig.user_id)
                                        "
                                        type="button"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                    >
                                        تواصل مع البائع
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

        <Modal :show="showRate">
            <form @submit.prevent="rate">
                <div
                    class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
                >
                    <div class="block mb-4 p-4">
                        <div
                            class="flex justify-between items-center p-2"
                            v-for="(value, index) in options"
                        >
                            <div class="block">{{ value }}</div>
                            <div class="flex flex-row-reverse">
                                <div v-for="i in 5">
                                    <svg
                                        v-if="i <= this.form.ratings[index]"
                                        aria-hidden="true"
                                        class="w-5 h-5 text-yellow-400 cursor-pointer"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                        @click="setRate(index, i)"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        ></path>
                                    </svg>
                                    <svg
                                        v-else
                                        aria-hidden="true"
                                        class="w-5 h-5 text-gray-300 dark:text-gray-500 cursor-pointer"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                        @click="setRate(index, i)"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800"
                    >
                        <label for="comment" class="sr-only">تقييمك</label>
                        <textarea
                            id="comment"
                            rows="4"
                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                            placeholder="اكتب تقييم..."
                            required
                            v-model="form.content"
                        ></textarea>
                    </div>
                    <div
                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600"
                    >
                        <button
                            type="submit"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800"
                        >
                            تقييم
                        </button>
                    </div>
                </div>
            </form>
        </Modal>
    </div>

    <Footer />
</template>
