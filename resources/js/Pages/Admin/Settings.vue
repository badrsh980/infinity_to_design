<script>
import { router } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            settings: {
                faqs: null,
            },
        };
    },
    props: {
        options: Object,
    },
    components: {
        InputLabel,
        InputError,
        AdminLayout,
    },
    beforeMount() {
        this.settings = this.options;
    },
    mounted() {},
    computed: {
        faqs() {
            return this.settings.faqs.map((faq) => {
                return {
                    id: faq.id ?? null,
                    title: faq.title,
                    body: faq.body,
                };
            });
        },
        about_menu() {
            return this.settings.about_menu.map((menu) => {
                return {
                    id: menu.id ?? null,
                    title: menu.title,
                    link: menu.link,
                };
            });
        },
        footer_menu() {
            return this.settings.footer_menu.map((menu) => {
                return {
                    id: menu.id ?? null,
                    title: menu.title,
                    link: menu.link,
                };
            });
        },
        reviews_types() {
            return Object.entries(this.settings.reviews_types).map((rate) => {
                return {
                    key: rate[0],
                    name: rate[1],
                };
            });
        },
        withdrawal_methods() {
            return Object.entries(this.settings.withdrawal_methods).map(
                (rate) => {
                    return {
                        key: rate[0],
                        name: rate[1],
                    };
                }
            );
        },
    },
    methods: {
        update() {
            // this.settings.faqs = this.faqs;
            // this.settings.about_menu = this.about_menu;
            // this.settings.footer_menu = this.footer_menu;
            // this.settings.reviews_types = this.reviews_types;
            // this.settings.withdrawal_methods = this.withdrawal_methods;

            router.post(
                route("admin.settings"),
                {
                    options: {
                        withdrawal_methods: this.withdrawal_methods,
                        reviews_types: this.reviews_types,
                        footer_menu: this.footer_menu,
                        about_menu: this.about_menu,
                        faqs: this.faqs,
                        facebook_url: this.settings.facebook_url,
                        twitter_url: this.settings.twitter_url,
                        currency_code: this.settings.currency_code,
                        payment_fees: this.settings.payment_fees,
                        stripe_public_key:
                            this.settings.stripe_public_key ??
                            this.options.stripe_public_key,
                        stripe_secret_key:
                            this.settings.stripe_secret_key ??
                            this.options.stripe_secret_key,
                        paypal_client_id:
                            this.settings.paypal_client_id ??
                            this.options.paypal_client_id,
                    },
                },
                {
                    onError: (error) => {
                        console.log(error);
                    },
                }
            );
        },
        tabs(id) {
            document.querySelectorAll(".dd").forEach((e) => {
                e.classList.add("hidden");
            });
            document.querySelector("#" + id).classList.remove("hidden");
        },
        deleteFAQ(index) {
            this.settings.faqs.splice(index, 1);
        },
        deleteAboutMenu(index) {
            this.settings.about_menu.splice(index, 1);
        },
        deleteFoterMenu(index) {
            this.settings.footer_menu.splice(index, 1);
        },
        deleteRate(key) {
            delete this.settings.reviews_types[key];
        },
        deleteMethod(key) {
            delete this.settings.withdrawal_methods[key];
        },
        add(name) {
            switch (name) {
                case "faqs":
                    this.settings.faqs.push({
                        id: Math.floor(Math.random() * 100),
                        title: "",
                        body: "",
                    });
                    break;
                case "about_menu":
                    this.settings.about_menu.push({
                        id: Math.floor(Math.random() * 100),
                        title: "",
                        link: "",
                    });
                    break;
                case "footer_menu":
                    this.settings.footer_menu.push({
                        id: Math.floor(Math.random() * 100),
                        title: "",
                        link: "",
                    });
                    break;
                case "rate":
                    this.settings.reviews_types[
                        Math.floor(Math.random() * 100)
                    ] = "";
                    break;
                case "method":
                    this.settings.withdrawal_methods[
                        Math.floor(Math.random() * 100)
                    ] = "";
                    break;

                default:
                    break;
            }
        },
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="update" class="block">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul
                        class="flex flex-wrap -mb-px text-sm font-medium text-center"
                        id="myTab"
                        role="tablist"
                    >
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg"
                                id="profile-tab"
                                type="button"
                                @click.prevent="tabs('profile')"
                            >
                                {{ $t("message.faqs") }}
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="about_menu-tab"
                                type="button"
                                @click.prevent="tabs('about_menu')"
                            >
                                {{ $t("message.about_menu") }}
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="footer_menu-tab"
                                type="button"
                                @click.prevent="tabs('footer_menu')"
                            >
                                {{ $t("message.footer_menu") }}
                            </button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="reviews_types-tab"
                                type="button"
                                @click.prevent="tabs('reviews_types')"
                            >
                                {{ $t("message.reviews_types") }}
                            </button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="withdrawal_methods-tab"
                                type="button"
                                @click.prevent="tabs('withdrawal_methods')"
                            >
                                {{ $t("message.withdrawal_methods") }}
                            </button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="other_options-tab"
                                type="button"
                                @click.prevent="tabs('other_options')"
                            >
                                {{ $t("message.other_options") }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div id="Options">
                    <div
                        class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 dd"
                        id="profile"
                    >
                        <div class="mb-4">
                            <div
                                class="block p-4 bg-gray-100 relative mb-4"
                                v-for="(faq, index) in faqs"
                            >
                                <div
                                    class="w-8 h-8 bg-red-500 text-white flex justify-center items-center absolute -left-4 -top-4 font-bold rounded-full cursor-pointer"
                                    @click="deleteFAQ(index)"
                                >
                                    X
                                </div>
                                <InputLabel
                                    :for="'faq_question' + index"
                                    :value="$t('message.question')"
                                />

                                <input
                                    type="text"
                                    :id="'faq_question' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                    v-model="faq.title"
                                />
                                <InputLabel
                                    :for="'answer_name' + index"
                                    :value="$t('message.answer')"
                                />

                                <textarea
                                    :id="'answer_name' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full"
                                    v-model="faq.body"
                                ></textarea>
                            </div>

                            <button
                                type="button"
                                class="py-2 px-4 bg-green-600 text-white font-bold"
                                @click.prevent="add('faqs')"
                            >
                                +
                            </button>
                        </div>
                    </div>
                    <div
                        class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 dd"
                        id="about_menu"
                    >
                        <div class="mb-4">
                            <div
                                class="block p-4 bg-gray-100 relative mb-4"
                                v-for="(menu, index) in about_menu"
                            >
                                <div
                                    class="w-8 h-8 bg-red-500 text-white flex justify-center items-center absolute -left-4 -top-4 font-bold rounded-full cursor-pointer"
                                    @click="deleteAboutMenu(index)"
                                >
                                    X
                                </div>
                                <InputLabel
                                    :for="'title' + index"
                                    :value="$t('message.title')"
                                />

                                <input
                                    type="text"
                                    :id="'title' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                    v-model="menu.title"
                                />
                                <InputLabel
                                    :for="'link' + index"
                                    :value="$t('message.link')"
                                />

                                <input
                                    type="text"
                                    :id="'link' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full"
                                    v-model="menu.link"
                                />
                            </div>

                            <button
                                type="button"
                                class="py-2 px-4 bg-green-600 text-white font-bold"
                                @click.prevent="add('about_menu')"
                            >
                                +
                            </button>
                        </div>
                    </div>
                    <div
                        class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 dd"
                        id="footer_menu"
                    >
                        <div class="mb-4">
                            <div
                                class="block p-4 bg-gray-100 relative mb-4"
                                v-for="(menu, index) in footer_menu"
                            >
                                <div
                                    class="w-8 h-8 bg-red-500 text-white flex justify-center items-center absolute -left-4 -top-4 font-bold rounded-full cursor-pointer"
                                    @click="deleteFoterMenu(index)"
                                >
                                    X
                                </div>
                                <InputLabel
                                    :for="'footer_menu_title' + index"
                                    :value="$t('message.title')"
                                />

                                <input
                                    type="text"
                                    :id="'footer_menu_title' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                    v-model="menu.title"
                                />
                                <InputLabel
                                    :for="'footer_menu_link' + index"
                                    :value="$t('message.link')"
                                />

                                <input
                                    type="text"
                                    :id="'footer_menu_link' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full"
                                    v-model="menu.link"
                                />
                            </div>
                        </div>

                        <button
                            type="button"
                            class="py-2 px-4 bg-green-600 text-white font-bold"
                            @click.prevent="add('footer_menu')"
                        >
                            +
                        </button>
                    </div>
                    <div
                        class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 dd"
                        id="reviews_types"
                    >
                        <div class="mb-4">
                            <div
                                class="block p-4 bg-gray-100 relative mb-4"
                                v-for="rate in reviews_types"
                            >
                                <div
                                    class="w-8 h-8 bg-red-500 text-white flex justify-center items-center absolute -left-4 -top-4 font-bold rounded-full cursor-pointer"
                                    @click="deleteRate(rate.key)"
                                >
                                    X
                                </div>
                                <InputLabel
                                    :for="'rate_title' + rate.key"
                                    :value="$t('message.title')"
                                />

                                <input
                                    type="text"
                                    :id="'rate_title' + rate.key"
                                    class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                    v-model="rate.name"
                                />
                            </div>
                        </div>

                        <button
                            type="button"
                            class="py-2 px-4 bg-green-600 text-white font-bold"
                            @click.prevent="add('rate')"
                        >
                            +
                        </button>
                    </div>
                    <div
                        class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 dd"
                        id="withdrawal_methods"
                    >
                        <div class="mb-4">
                            <div
                                class="block p-4 bg-gray-100 relative mb-4"
                                v-for="method in withdrawal_methods"
                            >
                                <div
                                    class="w-8 h-8 bg-red-500 text-white flex justify-center items-center absolute -left-4 -top-4 font-bold rounded-full cursor-pointer"
                                    @click="deleteMethod(method.key)"
                                >
                                    X
                                </div>
                                <InputLabel
                                    :for="'method_link' + method.key"
                                    :value="$t('message.title')"
                                />

                                <input
                                    type="text"
                                    :id="'method_link' + method.key"
                                    class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                    v-model="method.name"
                                />
                            </div>
                        </div>

                        <button
                            type="button"
                            class="py-2 px-4 bg-green-600 text-white font-bold"
                            @click.prevent="add('method')"
                        >
                            +
                        </button>
                    </div>
                    <div
                        class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 dd"
                        id="other_options"
                    >
                        <div class="mb-4">
                            <InputLabel
                                for="facebook_url"
                                :value="$t('message.facebook_url')"
                            />

                            <input
                                type="text"
                                id="facebook_url"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.facebook_url"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="twitter_url"
                                :value="$t('message.twitter_url')"
                            />

                            <input
                                type="text"
                                id="twitter_url"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.twitter_url"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="currency_code"
                                :value="$t('message.currency_code')"
                            />

                            <input
                                type="text"
                                id="currency_code"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.currency_code"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="payment_fees"
                                :value="$t('message.payment_fees')"
                            />

                            <input
                                type="text"
                                id="payment_fees"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.payment_fees"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="stripe_secret_key"
                                :value="$t('message.stripe_secret_key')"
                            />

                            <input
                                type="text"
                                id="stripe_secret_key"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.stripe_secret_key"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="stripe_public_key"
                                :value="$t('message.stripe_public_key')"
                            />

                            <input
                                type="text"
                                id="stripe_public_key"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.stripe_public_key"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="paypal_client_id"
                                :value="$t('message.paypal_client_id')"
                            />

                            <input
                                type="text"
                                id="paypal_client_id"
                                class="border-gray-500 rounded-sm shadow-sm w-full mb-4"
                                v-model="options.paypal_client_id"
                            />
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <button
                        class="py-2 px-4 border bg-primary-light text-white"
                    >
                        <span>{{ $t("message.submit") }}</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
