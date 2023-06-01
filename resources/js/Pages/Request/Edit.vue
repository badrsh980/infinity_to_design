<script>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

export default {
    data() {
        return {
            form: useForm({
                title: "",
                content: "",
                _token: this.$page.props.csrf_token,
            }),
        };
    },
    props: {
        categories: Object,
        request: Object,
    },
    components: {
        NavBar,
        Footer,
        InputError,
        InputLabel,
        Link,
    },
    mounted() {
        this.form.title = this.request.title;
        this.form.content = this.request.content;
    },
    methods: {
        updateRequest() {
            this.form.patch(
                route("member.requests.update", { request: this.request.id }),
                {
                    preserveScroll: true,
                }
            );
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
                            تعديل: {{ request.title }}
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="my-6">
                <div class="p-4 bg-white">
                    <form @submit.prevent="updateRequest">
                        <div class="mb-4">
                            <InputLabel for="title" value="عنوان الطلب" />

                            <input
                                type="text"
                                id="title"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                v-model="form.title"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.title"
                            />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="content" value="وصف الطلب" />

                            <textarea
                                id="content"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                style="min-height: 250px"
                                v-model="form.content"
                            >
                            </textarea>

                            <InputError
                                class="mt-2"
                                :message="form.errors.content"
                            />
                        </div>

                        <div class="mb-4">
                            <button
                                class="py-2 px-4 border bg-primary-light text-white"
                            >
                                <span>حفظ</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
