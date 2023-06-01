<script>
import { Link } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
// import { router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

export default {
    data() {
        return {
            page: 1,
            last_page: 0,
            current_page: 1,
            links: [],
        };
    },
    components: {
        Link,
        NavBar,
        Pagination,
    },
    props: {
        requests: Object,
        categories: Object,
    },
    mounted() {
        this.links = this.requests.links;
        this.current_page = this.requests.current_page;
        this.last_page = this.requests.last_page;
    },
    watch: {},
};
</script>

<template>
    <NavBar class="mb-10" :categories="categories" />

    <div class="mt-20 max-w-screen-xl mx-auto p-6">
        <nav class="flex justify-between items-center" aria-label="Breadcrumb">
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
                        <span>{{ $t("message.requests") }}</span>
                    </div>
                </li>
            </ol>
            <div class="block" v-if="$page.props.auth.authenticated">
                <Link
                    :href="route('member.requests.create')"
                    class="py-2 px-4 rounded-sm bg-primary-light text-white text-base"
                >
                    إضافة طلب
                </Link>
            </div>
        </nav>

        <div class="my-6 bg-white">
            <section class="bg-white dark:bg-gray-900 py-8">
                <div class="mx-auto">
                    <article
                        class="mb-6 text-base bg-white border-b border-b-gray-200 grid grid-cols-1 lg:grid-cols-3"
                        v-for="request in requests.data"
                    >
                        <footer
                            class="p-6 flex justify-start items-center mb-2 col-span-2"
                        >
                            <p
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
                            </p>
                            <p
                                class="text-sm text-gray-600 dark:text-gray-400 flex flex-col items-start justify-center"
                            >
                                <span class="text-xl w-full block mb-3">
                                    <Link
                                        :href="
                                            route('requests.show', {
                                                slug: request.slug,
                                            })
                                        "
                                        >{{ request.title }}</Link
                                    >
                                </span>
                                <span>
                                    <font-awesome-icon
                                        icon="user"
                                        class="ml-2"
                                    />
                                    <Link
                                        :href="
                                            route('user', {
                                                username: request.user.username,
                                            })
                                        "
                                        class="ml-2"
                                        >{{ request.user.name }}</Link
                                    >
                                    <font-awesome-icon
                                        icon="clock"
                                        class="ml-2"
                                    />
                                    <time
                                        class="ml-2"
                                        :title="request.created_date"
                                        v-text="request.created_date"
                                    ></time>
                                </span>
                            </p>
                        </footer>
                        <footer
                            v-if="request.last_comment"
                            class="p-6 flex justify-start items-center mb-2"
                        >
                            <p
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
                                            request.last_comment.user.thumbnail
                                        "
                                        :alt="request.last_comment.user.name"
                                    />
                                </Link>
                            </p>
                            <p
                                class="text-sm text-gray-600 dark:text-gray-400 flex flex-col items-start justify-center"
                            >
                                <span class="text-base w-full block mb-3">
                                    <Link
                                        :href="
                                            route('user', {
                                                username: request.user.username,
                                            })
                                        "
                                        >{{ request.user.name }}</Link
                                    >
                                </span>
                                <span>
                                    <font-awesome-icon
                                        icon="clock"
                                        class="ml-2"
                                    />
                                    <span class="ml-2">اخر تفاعل</span>
                                    <time
                                        class="ml-2"
                                        :title="request.created_date"
                                        v-text="request.created_date"
                                    ></time>
                                </span>
                            </p>
                        </footer>
                    </article>
                </div>
            </section>

            <Pagination :model="requests" />
        </div>
    </div>
</template>

<style>
body {
    background: #f8f8f8;
}
</style>
