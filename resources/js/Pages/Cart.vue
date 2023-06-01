<script>
import { Link } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import CartItem from "@/Components/CartItem.vue";
import { router } from "@inertiajs/vue3";

export default {
    data() {
        return {
            prices: {},
            total: 0,
            all: 0,
            fees: 2,
            formatter: new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            }),
        };
    },
    components: {
        Link,
        NavBar,
        Footer,
        CartItem,
    },
    props: {
        cart: Object,
        categories: Object,
    },
    methods: {
        deleteItem(item_id) {
            router.visit(route("cart"), {
                method: "post",
                data: {
                    item_id,
                },
                only: ["cart"],
            });
        },
        calculateTotal(value) {
            var t = 0;
            this.prices[value.item_id] = parseFloat(value.price);

            for (const [i, p] of Object.entries(this.prices)) {
                t += parseFloat(p);
            }

            this.total = this.formatter.format(t);

            this.all = this.formatter.format(parseFloat(t) + this.fees);
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
                            :href="route('cart')"
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
                            سلة المشتريات
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="my-6 bg-white">
                <div v-if="cart.items.length > 0">
                    <div class="relative overflow-x-auto">
                        <table
                            class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-base text-white uppercase bg-primary-light"
                            >
                                <tr>
                                    <th scope="col" class="p-4">الخدمة</th>
                                    <th scope="col" class="p-4">التكلفة</th>
                                    <th scope="col" class="p-4">خيارات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b" v-for="item in cart.items">
                                    <CartItem
                                        :item="item"
                                        :key="'cart-item-' + item.id"
                                        @deleteItem="deleteItem"
                                        @prices="calculateTotal"
                                    />
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-end w-full md:w-3/4">
                            <div class="my-6 w-64 text-xl">
                                <div
                                    class="flex justify-between items-center my-2"
                                >
                                    <div>الإجمالي</div>
                                    <div v-text="total"></div>
                                </div>
                                <div
                                    class="flex justify-between items-center my-2"
                                >
                                    <div>الرسوم</div>
                                    <div
                                        v-text="formatter.format(this.fees)"
                                    ></div>
                                </div>
                                <div
                                    class="flex justify-between items-center my-2 font-bold"
                                >
                                    <div>المجموع</div>
                                    <div v-text="all"></div>
                                </div>
                                <div class="my-2">
                                    <Link
                                        :href="route('pay')"
                                        class="block text-center text-white bg-primary-light hover:bg-primary-dark duration-100 font-medium rounded-xs text-sm px-5 py-2 w-full"
                                    >
                                        الدفع
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="flex justify-center items-center p-4">
                    لا توجد أية بيانات في سلة مشترياتك
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
