<script>
import { Link, useForm, router } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Dropdown from "@/Components/Dropdown.vue";

export default {
    data() {
        return {
            form: useForm({
                content: null,
            }),
        };
    },
    components: {
        Link,
        NavBar,
        Dropdown,
    },
    props: {
        request: Object,
        categories: Object,
    },
    methods: {
        sendComment() {
            this.form.post(
                route("requests.show", { slug: this.request.slug }),
                {
                    onError: (error) => {
                        // console.log(error);
                    },
                }
            );
        },
        createChat(user_id) {
            router.post(route("create-chat", { user_id }));
        },
    },
};
</script>

<template>
    <NavBar class="mb-10" :categories="categories" />

    <div class="mt-20 max-w-screen-xl mx-auto p-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-1 md:space-x-3">
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
                    <Link
                        :href="route('requests')"
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
                        <span>{{ $t("message.requests") }}</span>
                    </Link>
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
                        <span>{{ request.title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="my-2">
            <section
                class="p-2 mb-6 block lg:flex justify-between items-center"
            >
                <div class="block text-2xl">
                    {{ request.title }}
                </div>
                <div class="block">
                    <a
                        href="#add-comment"
                        class="py-2 px-4 rounded-sm bg-primary-light text-white text-base"
                    >
                        إضافة تعليق
                    </a>
                </div>
            </section>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="col-span-2">
                    <div class="bg-white p-4 mb-4 text-base">
                        {{ request.content }}
                    </div>
                    <div class="bg-white mb-4">
                        <div class="p-4 text-xl border-b border-gray-200">
                            <span>التعليقات</span>
                            <span class="mx-1"
                                >({{ request.comments_count }})</span
                            >
                        </div>
                        <article
                            class="mb-6 p-4 text-base bg-white border-b border-b-gray-200 relative"
                            v-for="comment in request.comments"
                            :id="'comment_' + comment.id"
                        >
                            <!-- <button
                                class="absolute top-2 left-2 bg-gray-200 w-8 h-8 rounded-full flex justify-center items-center text-gray-400"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'ellipsis-vertical']"
                                />
                            </button> -->
                            <Dropdown
                                align="left"
                                width="32"
                                contentClasses="py-1 bg-white top-9 left-2"
                            >
                                <template #trigger>
                                    <button
                                        type="button"
                                        class="absolute top-2 left-2 bg-gray-200 w-8 h-8 rounded-full flex justify-center items-center text-gray-400"
                                    >
                                        <font-awesome-icon
                                            :icon="['fas', 'ellipsis-vertical']"
                                        />
                                    </button>
                                </template>

                                <template #content>
                                    <ul>
                                        <li>
                                            <button
                                                type="button"
                                                @click.prevent="
                                                    createChat(comment.user_id)
                                                "
                                                class="block w-full px-4 py-2 text-right text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                            >
                                                تواصل
                                            </button>
                                        </li>
                                    </ul>
                                </template>
                            </Dropdown>
                            <footer
                                class="p-6 flex justify-start items-center mb-2 col-span-2"
                            >
                                <p
                                    class="inline-flex items-center ml-3 text-sm text-gray-900 dark:text-white"
                                >
                                    <Link
                                        :href="
                                            route('user', {
                                                username: comment.user.username,
                                            })
                                        "
                                    >
                                        <img
                                            class="ml-4 w-16 h-16 rounded-full"
                                            :src="
                                                '/storage/images/users/' +
                                                comment.user.thumbnail
                                            "
                                            :alt="comment.user.name"
                                        />
                                    </Link>
                                </p>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400 flex flex-col items-start justify-center"
                                >
                                    <span class="text-xl w-full block mb-1">
                                        <Link
                                            :href="
                                                route('user', {
                                                    username:
                                                        comment.user.username,
                                                })
                                            "
                                        >
                                            {{ comment.user.name }}
                                        </Link>
                                    </span>
                                    <span class="text-gray-400 text-sm">
                                        <font-awesome-icon
                                            icon="clock"
                                            class="ml-2"
                                        />
                                        <time
                                            class="ml-2"
                                            :title="comment.created_date"
                                            v-text="comment.created_date"
                                        ></time>
                                    </span>
                                </p>
                            </footer>
                            <div class="block">
                                {{ comment.content }}
                            </div>
                        </article>
                    </div>
                    <div
                        class="bg-white mb-4"
                        id="add-comment"
                        v-if="
                            $page.props.auth.authenticated &&
                            $page.props.auth.user.id != request.user_id
                        "
                    >
                        <div class="p-4 text-xl border-b border-gray-200">
                            إضافة تعليق
                        </div>
                        <div class="block p-4">
                            <form @submit.prevent="sendComment">
                                <div
                                    class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert"
                                    v-if="$page.props.flash.message"
                                >
                                    {{ $page.props.flash.message }}
                                </div>
                                <div
                                    class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
                                >
                                    <div
                                        class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800"
                                    >
                                        <label for="comment" class="sr-only"
                                            >تعليقك</label
                                        >
                                        <textarea
                                            id="comment"
                                            rows="4"
                                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                            placeholder="تعليقك..."
                                            v-model="form.content"
                                        ></textarea>
                                        <div
                                            class="block"
                                            v-if="form.errors.content"
                                        >
                                            <p
                                                class="mt-2 text-sm text-red-600 dark:text-red-500"
                                            >
                                                {{ form.errors.content }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600"
                                    >
                                        <button
                                            type="submit"
                                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800"
                                        >
                                            أرسل
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <p
                                class="ml-auto text-xs text-gray-500 dark:text-gray-400"
                            >
                                التعليق لا يحتوي على معلومات اتصال خارجية ولا
                                يخالف شروط
                                <a
                                    href="#"
                                    class="text-blue-600 dark:text-blue-500 hover:underline"
                                    >موقع أنفينيتي ديزاين</a
                                >.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="bg-white mb-4">
                        <div class="p-4 text-base border-b border-gray-200">
                            عن الموضوع
                        </div>
                        <div
                            class="p-4 text-base border-b border-gray-100 grid grid-cols-1 md:grid-cols-2"
                        >
                            <div>تاريخ النشر</div>
                            <div>{{ request.created_date }}</div>
                        </div>
                        <div class="p-4">
                            <div class="text-base mb-3">ناشر الموضوع</div>
                            <div
                                class="inline-flex items-center ml-3 text-sm text-gray-900 dark:text-white"
                            >
                                <Link
                                    :href="
                                        route('user', {
                                            username: request.user.username,
                                        })
                                    "
                                >
                                    <img
                                        class="ml-4 w-16 h-16 rounded-full"
                                        :src="
                                            '/storage/images/users/' +
                                            request.user.thumbnail
                                        "
                                        :alt="request.user.name"
                                    />
                                </Link>
                                <div class="block">
                                    <Link
                                        :href="
                                            route('user', {
                                                username: request.user.username,
                                            })
                                        "
                                        >{{ request.user.name }}</Link
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
body {
    background: #f8f8f8;
}
</style>
