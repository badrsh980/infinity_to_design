<script>
import { Link, useForm } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import Alert from "@/Components/Alert.vue";

export default {
    data() {
        return {
            form: useForm({
                username: null,
                name: null,
                email: null,
                address: null,
                country: null,
                specialization: null,
                description: null,
                withdrawal_email: null,
                withdrawal_method: null,

                old_password: null,
                password: null,
                password_confirmation: null,
            }),
        };
    },
    props: {
        user: Object,
        categories: Object,
        countries: Object,
        withdrawal_methods: Object,
    },
    components: { Link, NavBar, Footer, Alert },
    methods: {
        update() {
            this.form.post(route("profile"));
        },
        thumbnail() {
            var image = document.getElementById("thumbnail").files[0];

            const form = useForm({
                thumbnail: image,
            });

            form.post(route("profile"));
        },
    },
    mounted() {
        this.form.username = this.user.username;
        this.form.name = this.user.name;
        this.form.email = this.user.email;
        this.form.address = this.user.address;
        this.form.country = this.user.country;
        this.form.specialization = this.user.specialization;
        this.form.description = this.user.description;
        this.form.withdrawal_email = this.user.withdrawal_email;
        this.form.withdrawal_method = this.user.withdrawal_method;
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
                            تعديل الحساب
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div class="w-full md:w-3/4 mx-auto bg-white p-6">
                    <Alert :message="$page.props.flash.message" />
                    <form @submit.prevent="update">
                        <div class="mb-6">
                            <label
                                for="thumbnail"
                                class="flex justify-center items-center cursor-pointer rounded-full w-32 h-32 overflow-hidden mx-auto relative"
                            >
                                <img
                                    class="w-full h-full"
                                    :src="`/storage/images/users/${user.thumbnail}`"
                                />
                                <div
                                    class="w-full h-full bg-black bg-opacity-40 absolute top-0 left-0 flex justify-center items-center"
                                >
                                    <font-awesome-icon
                                        class="text-white text-xl"
                                        :icon="['fas', 'camera']"
                                    />
                                </div>
                                <input
                                    type="file"
                                    id="thumbnail"
                                    class="hidden"
                                    @change="thumbnail"
                                />
                            </label>
                        </div>

                        <div class="text-2xl text-bold mb-6 text-center">
                            تعديل المعلومات الشخصية
                        </div>
                        <div
                            class="block md:grid grid-cols-1 md:grid-cols-2 gap-4 mb-6"
                        >
                            <div class="mb-2 md:mb-6">
                                <label
                                    for="username"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >اسم المستخدم</label
                                >
                                <input
                                    type="text"
                                    id="username"
                                    v-model="form.username"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    disabled
                                />
                                <div
                                    v-if="form.errors.username"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.username }}
                                </div>
                            </div>
                            <div class="mb-2 md:mb-6">
                                <label
                                    for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >الاسم الكامل</label
                                >
                                <input
                                    type="text"
                                    id="name"
                                    v-model="form.name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    required
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div class="mb-2 md:mb-6">
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
                                    disabled
                                />
                                <div
                                    v-if="form.errors.email"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.email }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label
                                    for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >العنوان</label
                                >
                                <input
                                    type="text"
                                    id="address"
                                    v-model="form.address"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    required
                                />
                                <div
                                    v-if="form.errors.address"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.address }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label
                                    for="country"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >الدولة</label
                                >
                                <select
                                    id="country"
                                    v-model="form.country"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    required
                                >
                                    <option
                                        v-for="(name, code) in countries"
                                        :value="code"
                                    >
                                        {{ name }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.country"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.country }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label
                                    for="specialization"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >التخصص</label
                                >
                                <input
                                    type="text"
                                    id="specialization"
                                    v-model="form.specialization"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    required
                                />
                                <div
                                    v-if="form.errors.specialization"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.specialization }}
                                </div>
                            </div>
                            <div class="mb-6 col-span-2">
                                <label
                                    for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >نبذة عني</label
                                >
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full h-40"
                                    required
                                ></textarea>
                                <div
                                    v-if="form.errors.description"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.description }}
                                </div>
                            </div>
                        </div>
                        <div class="text-2xl text-bold mb-6 text-center">
                            معلومات السحب
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="mb-2">
                                <label
                                    for="withdrawal_email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >البريد الالكتروني</label
                                >
                                <input
                                    type="email"
                                    id="withdrawal_email"
                                    v-model="form.withdrawal_email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    required
                                />
                                <div
                                    v-if="form.errors.withdrawal_email"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.withdrawal_email }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label
                                    for="withdrawal_method"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >طريقة السحب</label
                                >
                                <select
                                    id="withdrawal_method"
                                    v-model="form.withdrawal_method"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                    required
                                >
                                    <option
                                        v-for="(name, id) in withdrawal_methods"
                                        :value="id"
                                    >
                                        {{ name }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.withdrawal_method"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.withdrawal_method }}
                                </div>
                            </div>
                        </div>
                        <div class="text-2xl text-bold mb-6 text-center">
                            تغيير كلمة المرور
                        </div>
                        <div class="mb-6">
                            <div class="mb-2">
                                <label
                                    for="old_password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >كلمة السر القديمة</label
                                >
                                <input
                                    type="password"
                                    id="old_password"
                                    v-model="form.old_password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                />
                                <div
                                    v-if="form.errors.old_password"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.old_password }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label
                                    for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >كلمة السر الجديدة</label
                                >
                                <input
                                    type="password"
                                    id="password"
                                    v-model="form.password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                />
                                <div
                                    v-if="form.errors.password"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.password }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label
                                    for="password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >تأكيد كلمة السر الجديدة</label
                                >
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                                />
                                <div
                                    v-if="form.errors.password_confirmation"
                                    class="mt-2 text-sm text-red-600 dark:text-red-500"
                                >
                                    {{ form.errors.password_confirmation }}
                                </div>
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="text-white bg-primary-light hover:bg-primary-dark duration-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                        >
                            حفظ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
