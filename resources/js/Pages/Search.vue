<script>
import { Link } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import RateStars from "@/Components/RateStars.vue";
import GigImagesCarousel from "@/Components/GigImagesCarousel.vue";
import { router } from "@inertiajs/vue3";

export default {
    data() {
        return {
            page: 1,
            last_page: 0,
            current_page: 1,
            links: [],

            search: "",
            rate: 0,
        };
    },
    components: {
        Link,
        NavBar,
        GigImagesCarousel,
        RateStars,
    },
    props: {
        // category: Object,
        gigs: Object,
        // slug: String,
        // categories: Object,
    },
    mounted() {
        this.links = this.gigs.links;
        this.current_page = this.gigs.current_page;
        this.last_page = this.gigs.last_page;

        const url = new URL(location.href);

        // this.search = url.searchParams.get("search") ?? "";
        // this.rate = url.searchParams.get("rate") ?? 0;
    },
    // watch: {
    //     search(value) {
    //         router.get(
    //             route("category", { slug: this.slug }),
    //             { search: value },
    //             {
    //                 preserveState: true,
    //             }
    //         );
    //     },
    //     rate(value) {
    //         router.get(
    //             route("category", { slug: this.slug }),
    //             { rate: value },
    //             {
    //                 preserveState: true,
    //             }
    //         );
    //     },
    // },
};
</script>

<template>
    <NavBar class="mb-10" />

    <div class="mt-20 max-w-screen-xl mx-auto p-6">
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
                        <a
                            href="#"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                        >
                            البحث
                        </a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="my-6">
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-4">
                <!-- <div class="block bg-gray-50 shadow-md p-2">
                    <div class="mb-4">
                        <h2
                            class="mb-2 text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            بحث
                        </h2>
                        <form>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
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
                                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-model="search"
                                />
                            </div>
                        </form>
                    </div>
                    <div class="mb-4">
                        <h2
                            class="mb-2 text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            الأقسام
                        </h2>
                        <ul
                            class="max-w-md space-y-1 text-gray-500 dark:text-gray-400 mr-5"
                        >
                            <li
                                v-for="cat in this.categories"
                                :key="'cat-' + cat.id"
                            >
                                <Link
                                    :href="
                                        route('category', { slug: cat.slug })
                                    "
                                    class="text-base mb-4 hover:text-primary-light duration-100 flex justify-between items-center"
                                >
                                    <span v-text="cat.name"></span>
                                    <span
                                        v-text="cat.count"
                                        class="inline-block bg-primary-light text-white px-4 py-1 rounded-xl text-sm"
                                    ></span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h2
                            class="mb-2 text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            تقييم الخدمة
                        </h2>
                        <div class="block max-w-md mr-5">
                            <div v-for="i in 4">
                                <div class="flex items-center mb-4">
                                    <label
                                        :for="'rate_' + i"
                                        class="text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer"
                                    >
                                        <input
                                            :id="'rate_' + i"
                                            type="radio"
                                            :value="i"
                                            v-model="rate"
                                            class="ml-2 w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                        <span v-for="j in 5">
                                            <font-awesome-icon
                                                v-if="j <= i"
                                                icon="star"
                                                class="text-orange-400"
                                            />
                                            <font-awesome-icon
                                                v-else
                                                icon="star"
                                                class="text-gray-400"
                                            />
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="lg:col-span-3 bg-gray-50 p-2">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <div
                            class="block relative bg-white shadow-md rounded-lg overflow-hidden"
                            v-for="gig in this.gigs.data"
                            :key="gig.id"
                        >
                            <GigImagesCarousel :gig="gig" />
                            <Link :href="route('gig', { slug: gig.slug })">
                                <div
                                    class="block text-base py-1 px-4"
                                    v-text="gig.title"
                                ></div>
                            </Link>
                            <RateStars :count="gig.r_count" :avg="gig.r_avg" />
                            <div class="block py-1 px-4">
                                <span> تبدأ من </span>
                                <span
                                    v-text="gig.price_formated"
                                    class="text-base font-bold"
                                ></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
