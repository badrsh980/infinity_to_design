<script>
import Footer from "@/Components/Footer.vue";
import NavBar from "@/Components/NavBar.vue";
import { Link, router } from "@inertiajs/vue3";

// defineProps({
//     categories: Object,
//     faqs: Object,
// });

// var search = null;

// function searchFor() {
//     router.post(route("search", { slug: search }));
// }

// function toggleAccordion(id) {
//     document.querySelectorAll(".accordion").forEach((e) => {
//         e.classList.add("hidden");
//     });
//     document.querySelectorAll(".accordion-icon").forEach((e) => {
//         e.classList.add("rotate-180");
//     });
//     document.getElementById("accordion-" + id).classList.remove("hidden");
//     document
//         .getElementById("accordion-icon-" + id)
//         .classList.remove("rotate-180");
// }

export default {
    data() {
        return {
            search: null,
        };
    },
    props: {
        categories: Object,
        faqs: Object,
    },
    components: { Footer, NavBar, Link },
    methods: {
        searchFor() {
            router.get(route("search", { slug: this.search }));
        },

        toggleAccordion(id) {
            document.querySelectorAll(".accordion").forEach((e) => {
                e.classList.add("hidden");
            });
            document.querySelectorAll(".accordion-icon").forEach((e) => {
                e.classList.add("rotate-180");
            });
            document
                .getElementById("accordion-" + id)
                .classList.remove("hidden");
            document
                .getElementById("accordion-icon-" + id)
                .classList.remove("rotate-180");
        },
    },
};
</script>

<template>
    <NavBar :categories="categories" />

    <div
        class="flex justify-center items-center flex-col h-screen mt-14"
        style="background-image: url('/storage/images/home.jpg')"
    >
        <div class="text-2xl md:text-5xl font-bold my-4">
            أكبر سوق عربي لبيع وشراء الخدمات المصغرة
        </div>
        <div class="text-xl md:text-3xl font-bold my-4">
            أنجز أعمالك بسهولة وأمان بأسعار تبدأ من 5$ فقط
        </div>
        <div class="my-4 w-3/4 md:w-1/2">
            <form @submit.prevent="searchFor">
                <label
                    for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only"
                    >Search</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"
                    >
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-gray-500 dark:text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            ></path>
                        </svg>
                    </div>
                    <input
                        type="search"
                        id="default-search"
                        class="block w-full p-6 pr-10 text-sm text-gray-900 border border-gray-300 bg-gray-50"
                        placeholder="البحث..."
                        required
                        v-model="search"
                    />
                    <button
                        type="submit"
                        class="text-white absolute left-2.5 bottom-2 bg-primary-light hover:bg-primary-dark duration-100 font-medium text-md px-6 py-4"
                    >
                        بحث
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="block p-6 md:p-14">
        <div class="text-2xl font-bold text-center w-full my-4">
            كافة الخدمات الإبداعية والاحترافية لتطوير وتنمية أعمالك
        </div>
        <div class="my-8 max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div
                    class="block"
                    v-for="category in categories"
                    :key="'klklk' + category.id"
                >
                    <Link
                        :href="route('category', { slug: category.slug })"
                        class="block relative cat-item"
                    >
                        <img :src="category.image" :alt="category.name" />
                        <div
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-fit h-fit text-xl text-white"
                            v-text="category.name"
                        ></div>
                    </Link>
                </div>
            </div>
        </div>
    </div>

    <div class="block p-6 md:p-14 bg-gray-100">
        <div class="text-2xl font-bold text-center w-full my-8">
            كيف يعمل موقع أنفينيتي ديزاين
        </div>
        <div class="my-8 max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="flex relative bg-white rounded-sm shadow-md p-6">
                    <div class="icon"></div>
                    <div class="info">
                        <div class="text-xl font-bold">استعرض الخدمات</div>
                        <div class="text-base">
                            ابحث عن الخدمة التي تحتاجها باستخدام مربع البحث في
                            الأعلى أو عبر التصنيفات.
                        </div>
                    </div>
                    <div
                        class="absolute w-10 h-10 left-5 -bottom-2 md:-bottom-5 bg-primary-light rounded-full text-2xl text-white flex justify-center items-center"
                    >
                        1
                    </div>
                </div>
                <div class="flex relative bg-white rounded-sm shadow-md p-6">
                    <div class="icon"></div>
                    <div class="info">
                        <div class="text-xl font-bold">اطلب الخدمة</div>
                        <div class="text-base">
                            راجع وصف الخدمة وتقييمات المشترين ثم اطلبها لفتح
                            تواصل مع البائع.
                        </div>
                    </div>
                    <div
                        class="absolute w-10 h-10 left-5 -bottom-2 md:-bottom-5 bg-primary-light rounded-full text-2xl text-white flex justify-center items-center"
                    >
                        2
                    </div>
                </div>
                <div class="flex relative bg-white rounded-sm shadow-md p-6">
                    <div class="icon"></div>
                    <div class="info">
                        <div class="text-xl font-bold">استلم خدمتك</div>
                        <div class="text-base">
                            تواصل مع البائع مباشرة داخل موقع أنفينيتي ديزاين حتى
                            استلام طلبك كاملاً.
                        </div>
                    </div>
                    <div
                        class="absolute w-10 h-10 left-5 -bottom-2 md:-bottom-5 bg-primary-light rounded-full text-2xl text-white flex justify-center items-center"
                    >
                        3
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="block p-6 md:p-14">
    </div> -->

    <div class="block p-6 md:p-14 bg-gray-100">
        <div class="text-2xl font-bold text-center w-full my-8">
            الأسئلة الشائعة
        </div>
        <div class="my-8 max-w-screen-xl mx-auto px-4">
            <div
                id="accordion-collapse"
                data-accordion="collapse"
                class="bg-white"
            >
                <div class="block" v-for="faq in faqs" :key="faq.id">
                    <h2 :id="'accordion-heading-' + faq.id">
                        <button
                            type="button"
                            class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                            @click="toggleAccordion(faq.id)"
                        >
                            <span v-text="faq.title"></span>
                            <svg
                                :id="'accordion-icon-' + faq.id"
                                class="w-6 h-6 rotate-180 shrink-0 accordion-icon"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </h2>
                    <div :id="'accordion-' + faq.id" class="accordion hidden">
                        <div
                            class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900"
                            v-text="faq.body"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="flex justify-center items-center flex-col p-14 bg-primary-dark text-white"
    >
        <div class="text-sxl font-bold text-center w-full my-8">
            أنجز أعمالك بسهولة وأمان
        </div>
        <Link
            :href="route('register')"
            type="button"
            class="text-white bg-primary-light font-medium rounded-sm text-md px-4 py-2 text-center mx-auto"
        >
            <font-awesome-icon :icon="['fas', 'user-plus']" />
            <span class="mx-1"> حساب جديد </span>
        </Link>
    </div>

    <Footer />
</template>
