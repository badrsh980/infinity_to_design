<script setup>
import Footer from "@/Components/Footer.vue";
import NavBar from "@/Components/NavBar.vue";

import { Link } from "@inertiajs/vue3";

function sidebar() {
    document.getElementById("ss").classList.toggle("activeSideBar");
}
</script>
<template>
    <div class="md:pr-64">
        <NavBar />
    </div>
    <div class="mt-12">
        <div>
            <button
                @click.prevent="sidebar"
                type="button"
                class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            >
                <span class="sr-only">Open sidebar</span>
                <svg
                    class="w-6 h-6"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                    ></path>
                </svg>
            </button>
            <aside
                id="ss"
                class="fixed top-0 -right-64 md:right-0 z-40 w-64 h-screen mt-14"
                aria-label="Sidenav"
            >
                <div
                    class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
                >
                    <ul class="space-y-2">
                        <li>
                            <Link
                                :href="route('admin.users.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.users")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.gigs.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.gigs")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.orders.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.orders")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.categories.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.categories")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.messages.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.messages")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.posts.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.posts")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.reviews.index')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.reviews")
                                }}</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.settings')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <span class="ml-3">{{
                                    $t("message.settings")
                                }}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        <div class="md:pr-64 shadow-md">
            <slot />
        </div>
    </div>
    <div class="md:pr-64">
        <Footer />
    </div>
</template>

<style>
.activeSideBar {
    right: 0;
    width: 100%;
    transition: 0.3s;
}
</style>
