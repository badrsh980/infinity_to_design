<script setup>
import { Link, usePage } from "@inertiajs/vue3";
const options = usePage().props.options;
const posts = usePage().props.posts;
</script>

<template>
    <div
        class="my-8 max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3"
    >
        <div class="block">
            <div class="text-xl font-bold text-primary-dark">
                موقع أنفينيتي ديزاين
            </div>
            <div class="my-4">
                <ul>
                    <li
                        v-for="menu in options.about_menu"
                        :key="'about_menu' + menu.id"
                    >
                        <Link
                            :href="menu.link"
                            v-text="menu.title"
                            class="my-4 block text-primary-light"
                        ></Link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="block">
            <div class="text-xl font-bold text-primary-dark">
                مدونة أنفينيتي ديزاين
            </div>
            <div class="my-4">
                <ul>
                    <li v-for="post in posts" :key="'post' + post.id">
                        <Link
                            :href="route('blog', { slug: post.slug })"
                            v-text="post.title"
                            class="my-4 block text-primary-light"
                        ></Link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="block">
            <div class="text-xl font-bold text-primary-dark">تابعنا</div>
            <div class="my-4 flex">
                <a
                    :href="options.facebook_url"
                    target="_blank"
                    class="flex justify-center items-center w-12 rounded-sm mx-2 h-12 text-white p-2 bg-primary-light text-xl"
                >
                    <font-awesome-icon :icon="['fab', 'facebook-f']" />
                </a>
                <a
                    :href="options.twitter_url"
                    target="_blank"
                    class="flex justify-center items-center w-12 rounded-sm mx-2 h-12 text-white p-2 bg-primary-light text-xl"
                >
                    <font-awesome-icon :icon="['fab', 'twitter']" />
                </a>
            </div>
            <div class="text-xl font-bold text-primary-dark">
                وسائل الدفع المتاحة
            </div>
            <div class="my-4 flex">
                <font-awesome-icon
                    class="text-gray-400 text-4xl mx-1 duration-100 hover:text-primary-light"
                    :icon="['fab', 'cc-paypal']"
                />
                <font-awesome-icon
                    class="text-gray-400 text-4xl mx-1 duration-100 hover:text-primary-light"
                    :icon="['fab', 'cc-visa']"
                />
                <font-awesome-icon
                    class="text-gray-400 text-4xl mx-1 duration-100 hover:text-primary-light"
                    :icon="['fab', 'cc-mastercard']"
                />
            </div>
        </div>
    </div>

    <div class="p-4 bg-gray-100">
        <div
            class="max-w-screen-xl mx-auto block lg:flex lg:justify-between lg:items-center"
        >
            <div class="block">
                <ul class="block md:flex">
                    <li v-for="menu in options.footer_menu">
                        <Link
                            :href="menu.link"
                            class="text-gray-500 font-medium text-md px-4 py-2 text-center mx-1 my-2 md:my-4 block"
                            v-text="menu.title"
                        >
                        </Link>
                    </li>
                </ul>
            </div>
            <div class="block text-center">
                جميع الحقوق محفوطة {{ new Date().getFullYear() }} أنفينيتي
                ديزاين
            </div>
        </div>
    </div>
</template>
