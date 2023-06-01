<script>
import { Link, router, useForm } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import RateStars from "@/Components/RateStars.vue";
import GigImagesCarousel from "@/Components/GigImagesCarousel.vue";
import ModalVue from "@/Components/Modal.vue";
import { Modal } from "flowbite";

export default {
    data() {
        return {
            total: 0,

            extras: [],
            modal: null,

            showReplyModal: false,

            form: useForm({
                content: null,
                review_id: null,
            }),
        };
    },
    components: {
        Link,
        NavBar,
        GigImagesCarousel,
        RateStars,
        Footer,
        ModalVue,
    },
    props: {
        gig: Object,
        recommended_gigs: Object,
        reviews_types: Object,
        categories: Object,
    },
    methods: {
        formatPrice(value = 0) {
            if (typeof value !== "number") {
                return value;
            }
            var formatter = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            });
            return formatter.format(parseFloat(value));
        },
        addItemToCart() {
            axios
                .post(route("cart.add"), {
                    gig_id: this.gig.id,
                    extras: this.extras,
                })
                .then((response) => {
                    if (response.data.status) {
                        this.modal = new Modal(
                            document.getElementById("popup-modal")
                        );
                        this.modal.show();
                    }
                })
                .catch((error) => {
                    // console.log(error);
                });
        },
        createChat(user_id) {
            router.post(route("create-chat", { user_id }));
        },
        makeReply(review_id) {
            this.form.review_id = review_id;
            this.showReplyModal = true;
        },
        reply() {
            router.post(
                route("create-reply", { slug: this.gig.slug }),
                {
                    content: this.form.content,
                    review_id: this.form.review_id,
                    gig_id: this.gig.id,
                    slug: this.gig.slug,
                },
                {
                    onFinish: () => {
                        this.showReplyModal = false;
                    },
                }
            );
        },
    },
    mounted() {
        this.total = parseFloat(this.gig.price);
        // console.log(this.gig.id);
    },
    watch: {
        extras() {
            var extras_price = 0;

            this.extras.forEach((e) => {
                extras_price += parseFloat(e.price);
            });

            this.total = parseFloat(this.gig.price) + parseFloat(extras_price);
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
                                v-text="gig.category.name"
                            >
                            </a>
                        </div>
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
                                v-text="gig.title"
                            >
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-3">
                        <div class="bg-white shadow-md p-2 mb-4">
                            <h1 class="text-3xl mb-6" v-text="gig.title"></h1>
                            <div class="slider mb-6">
                                <GigImagesCarousel
                                    :gig="gig"
                                    :showUser="false"
                                    :height="true"
                                ></GigImagesCarousel>
                            </div>
                            <div
                                class="description"
                                v-html="gig.description"
                            ></div>
                        </div>
                        <div
                            class="bg-white shadow-md mb-4"
                            v-if="gig.extras.length > 0"
                        >
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                تطويرات متوفرة لهذه الخدمة
                            </div>
                            <div class="mt-4 p-2">
                                <div
                                    class="p-2 border-b-2 border-gray-100 last-of-type:border-0"
                                    v-for="extra in gig.extras"
                                >
                                    <div class="flex items-center mb-1">
                                        <input
                                            :id="'default-checkbox-' + extra.id"
                                            type="checkbox"
                                            v-model="extras"
                                            :value="{
                                                id: extra.id,
                                                price: extra.price,
                                            }"
                                            true-value="yes"
                                            false-value="no"
                                            class="cursor-pointer w-4 h-4 text-primary-light bg-gray-100 border-gray-300 rounded focus:ring-primary-light dark:focus:ring-primary-dark dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                        <label
                                            :for="
                                                'default-checkbox-' + extra.id
                                            "
                                            class="mr-2 text-xl font-medium text-gray-900 dark:text-gray-300 cursor-pointer"
                                            v-text="extra.title"
                                        ></label>
                                    </div>
                                    <div
                                        class="block text-gray-400 text-base mr-6"
                                    >
                                        <span class="mx-1">مقابل</span>
                                        <span
                                            class="mx-1"
                                            v-text="extra.price_formated"
                                        ></span>
                                        <span class="mx-1"
                                            >إضافية على سعر الخدمة.</span
                                        >
                                        <span
                                            class="mx-1"
                                            v-if="
                                                extra.change_gig_date == 'yes'
                                            "
                                        >
                                            سيزيد مدة التنفيذ
                                            <span
                                                v-text="extra.time_formated"
                                            ></span>
                                        </span>
                                        <span class="mx-1" v-else
                                            >لن يزيد مدة التنفيذ.</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow-md mb-4">
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                اشتري الخدمة
                            </div>
                            <div
                                class="p-8 flex justify-center items-center flex-col"
                            >
                                <div class="block mb-4">
                                    <span class="text-xl font-bold mx-1"
                                        >المبلغ</span
                                    >
                                    <span
                                        class="text-xl font-bold mx-1"
                                        v-text="formatPrice(total)"
                                    ></span>
                                </div>
                                <button
                                    @click="addItemToCart"
                                    type="button"
                                    class="text-white bg-primary-light hover:bg-primary-dark font-medium rounded-sm text-sm px-5 py-2.5 text-center inline-flex items-center ml-2 duration-100"
                                >
                                    <svg
                                        aria-hidden="true"
                                        class="w-5 h-5 ml-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                        ></path>
                                    </svg>
                                    إضافة الى السلة
                                </button>
                            </div>
                        </div>
                        <div
                            class="bg-white shadow-md mb-4"
                            v-if="this.recommended_gigs.length > 0"
                        >
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                خدمات مقترحة
                            </div>
                            <div
                                class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-4"
                            >
                                <div
                                    class="block relative bg-white shadow-md rounded-lg overflow-hidden"
                                    v-for="gig in this.recommended_gigs"
                                    :key="gig.id"
                                >
                                    <GigImagesCarousel :gig="gig" />
                                    <Link
                                        :href="route('gig', { slug: gig.slug })"
                                    >
                                        <div
                                            class="block text-base py-1 px-4"
                                            v-text="gig.title"
                                        ></div>
                                    </Link>
                                    <RateStars
                                        :count="gig.r_count"
                                        :avg="gig.r_avg"
                                    />
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
                        <div
                            class="bg-white shadow-md"
                            v-if="gig.reviews.length > 0"
                        >
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                آراء المشترين
                            </div>
                            <div class="mt-4 p-2">
                                <div
                                    class="p-2 border-b-2 border-gray-100 last-of-type:border-0"
                                    v-for="review in gig.reviews"
                                >
                                    <div
                                        class="flex justify-between items-center mb-2"
                                        v-for="rate in review.rates"
                                    >
                                        <span
                                            v-text="reviews_types[rate.name]"
                                        ></span>
                                        <RateStars
                                            :count="0"
                                            :avg="rate.count"
                                        />
                                    </div>

                                    <div class="block p-4">
                                        <div class="flex">
                                            <div
                                                class="z-40 w-14 h-14 rounded-full ml-4"
                                            >
                                                <Link
                                                    :href="
                                                        route('user', {
                                                            username:
                                                                review.user
                                                                    .username,
                                                        })
                                                    "
                                                >
                                                    <img
                                                        :src="
                                                            '/storage/images/users/' +
                                                            review.user
                                                                .thumbnail
                                                        "
                                                        class="w-full"
                                                    />
                                                </Link>
                                            </div>
                                            <div class="block">
                                                <div
                                                    class="block text-base font-bold hover:text-primary-light duration-100"
                                                >
                                                    <Link
                                                        :href="
                                                            route('user', {
                                                                username:
                                                                    review.user
                                                                        .username,
                                                            })
                                                        "
                                                        v-text="
                                                            review.user.username
                                                        "
                                                    >
                                                    </Link>
                                                </div>
                                                <div class="flex items-center">
                                                    <span
                                                        class="text-sm text-gray-400"
                                                    >
                                                        <font-awesome-icon
                                                            icon="user"
                                                        />
                                                        <span class="mx-2"
                                                            >المشتري</span
                                                        >
                                                    </span>
                                                    <span
                                                        class="text-sm text-gray-400"
                                                    >
                                                        <font-awesome-icon
                                                            icon="clock"
                                                        />
                                                        <span class="mx-2">{{
                                                            review.human_date
                                                        }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="block p-4"
                                        v-text="review.content"
                                    ></div>

                                    <div v-if="review.reply" class="mr-6">
                                        <div
                                            class="block p-4"
                                            v-text="review.reply"
                                        ></div>
                                    </div>
                                    <div
                                        v-if="
                                            $page.props.auth.authenticated &&
                                            !review.reply &&
                                            $page.props.auth.user.id ==
                                                gig.user_id
                                        "
                                        class="flex justify-start items-center"
                                    >
                                        <button
                                            @click="makeReply(review.id)"
                                            class="bg-primary-dark px-4 text-white rounded-md"
                                        >
                                            رد
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-1">
                        <div class="bg-white mb-4 shadow-md">
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                بطاقة الخدمة
                            </div>
                            <div class="p-2">
                                <div class="grid grid-cols-2 py-4 px-2 gap-y-4">
                                    <div class="block">التقييمات</div>
                                    <div class="block">
                                        <RateStars
                                            :avg="gig.r_avg"
                                            :count="gig.r_count"
                                        />
                                    </div>
                                    <div class="block">المشترين</div>
                                    <div class="block">{{ gig.o_count }}</div>
                                    <div class="block">طلبات جاري تنفيذها</div>
                                    <div class="block">{{ gig.a_count }}</div>
                                    <div class="block">سعر الخدمة يبدأ من</div>
                                    <div class="block">
                                        {{ gig.price_formated }}
                                    </div>
                                    <div class="block">مدة التسليم</div>
                                    <div class="block">
                                        {{ gig.time_formated }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white mb-4 shadow-md">
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                صاحب الخدمة
                            </div>
                            <div class="px-2 py-4">
                                <div class="flex justify-between items-center">
                                    <div class="block">
                                        <div class="flex">
                                            <div
                                                class="z-40 w-14 h-14 rounded-full ml-4"
                                            >
                                                <Link
                                                    :href="
                                                        route('user', {
                                                            username:
                                                                gig.user
                                                                    .username,
                                                        })
                                                    "
                                                >
                                                    <img
                                                        :src="
                                                            '/storage/images/users/' +
                                                            gig.user.thumbnail
                                                        "
                                                        class="w-full"
                                                    />
                                                </Link>
                                            </div>
                                            <div class="block">
                                                <div
                                                    class="block text-base font-bold hover:text-primary-light duration-100"
                                                >
                                                    <Link
                                                        :href="
                                                            route('user', {
                                                                username:
                                                                    gig.user
                                                                        .username,
                                                            })
                                                        "
                                                        v-text="
                                                            gig.user.username
                                                        "
                                                    >
                                                    </Link>
                                                </div>
                                                <div class="flex items-center">
                                                    <span
                                                        class="text-sm text-gray-400"
                                                    >
                                                        <font-awesome-icon
                                                            icon="user"
                                                        />
                                                        <span class="mx-2">{{
                                                            gig.user
                                                                .specialization
                                                        }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block">
                                        <button
                                            type="button"
                                            @click="createChat(gig.user.id)"
                                            class="focus:outline-none text-primary-dark bg-white border-1 border-primary-light hover:bg-primary-light hover:text-white duration-100 font-medium text-sm px-5 py-2.5"
                                        >
                                            تواصل
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <img src="/storage/images/guarantee.png" />
                        </div>
                        <div class="bg-white mb-4 shadow-md">
                            <div
                                class="text-base p-2 border-b-2 border-gray-100"
                            >
                                شارك الخدمة
                            </div>
                            <div
                                class="px-2 py-4 flex justify-center items-center"
                            >
                                <a
                                    :href="
                                        'https://www.facebook.com/sharer/sharer.php?u=' +
                                        route('gig', { slug: gig.slug })
                                    "
                                    target="_blank"
                                    class="flex justify-center items-center w-12 rounded-full mx-2 h-12 text-white p-2 bg-primary-light text-xl"
                                >
                                    <font-awesome-icon
                                        :icon="['fab', 'facebook-f']"
                                    />
                                </a>
                                <a
                                    :href="
                                        'https://twitter.com/intent/tweet?text=' +
                                        gig.title +
                                        '&url=' +
                                        route('gig', { slug: gig.slug })
                                    "
                                    target="_blank"
                                    class="flex justify-center items-center w-12 rounded-full mx-2 h-12 text-white p-2 bg-primary-light text-xl"
                                >
                                    <font-awesome-icon
                                        :icon="['fab', 'twitter']"
                                    />
                                </a>
                                <a
                                    :href="
                                        'https://t.me/share/url?url=' +
                                        route('gig', { slug: gig.slug })
                                    "
                                    target="_blank"
                                    class="flex justify-center items-center w-12 rounded-full mx-2 h-12 text-white p-2 bg-primary-light text-xl"
                                >
                                    <font-awesome-icon
                                        :icon="['fab', 'telegram']"
                                    />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        id="popup-modal"
        tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 text-center">
                    <svg
                        aria-hidden="true"
                        class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                    <h3
                        class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"
                    >
                        تم إضافة الخدمة الى سلة المشتريات
                    </h3>
                    <div class="w-full flex justify-between items-center">
                        <a
                            :href="route('cart')"
                            class="text-white bg-primary-light hover:bg-primary-dark font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                        >
                            ادفع الآن
                        </a>
                        <button
                            @click="this.modal.hide()"
                            type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 0"
                        >
                            متابعة الشراء
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ModalVue :show="showReplyModal">
        <form @submit.prevent="reply()">
            <div
                class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
            >
                <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                    <label for="content" class="sr-only"
                        >الرد على التقييم</label
                    >
                    <textarea
                        id="content"
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
                        تأكيد
                    </button>
                </div>
            </div>
        </form>
    </ModalVue>

    <Footer />
</template>
