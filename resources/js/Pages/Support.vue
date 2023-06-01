<script>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import Alert from "@/Components/Alert.vue";

export default {
    data() {
        return {
            form: useForm({
                name: null,
                subject: null,
                message: null,
                email: null,
            }),
        };
    },
    props: {
        categories: Object,
    },
    components: { Link, NavBar, Footer, Alert },
    methods: {
        send() {
            this.form.post(route("support"));
        },
    },
    mounted() {
        if (usePage().props.auth.authenticated) {
            this.form.name = usePage().props.auth.user.name;
            this.form.email = usePage().props.auth.user.email;
        }
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
                            مركز المساعدة
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div class="w-full md:w-3/4 mx-auto bg-white p-6">
                    <Alert :message="$page.props.flash.message" />
                    <form @submit.prevent="send">
                        <div class="mb-2">
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >الإسم الكامل</label
                            >
                            <input
                                type="text"
                                id="username"
                                v-model="form.name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                            />
                            <div
                                v-if="form.errors.name"
                                class="mt-2 text-sm text-red-600 dark:text-red-500"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="mb-2">
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >البريد الالكتروني</label
                            >
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                            />
                            <div
                                v-if="form.errors.email"
                                class="mt-2 text-sm text-red-600 dark:text-red-500"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>
                        <div class="mb-2">
                            <label
                                for="subject"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >الموضوع</label
                            >
                            <input
                                type="text"
                                id="subject"
                                v-model="form.subject"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                            />
                            <div
                                v-if="form.errors.subject"
                                class="mt-2 text-sm text-red-600 dark:text-red-500"
                            >
                                {{ form.errors.subject }}
                            </div>
                        </div>
                        <div class="mb-2">
                            <label
                                for="message"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >الرسالة</label
                            >
                            <textarea
                                id="message"
                                v-model="form.message"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full h-48"
                            ></textarea>
                            <div
                                v-if="form.errors.message"
                                class="mt-2 text-sm text-red-600 dark:text-red-500"
                            >
                                {{ form.errors.message }}
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="text-white bg-primary-light hover:bg-primary-dark duration-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                        >
                            ارسال
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
