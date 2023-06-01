<script>
import { Link, usePage, router } from "@inertiajs/vue3";
import Dropdown from "./Dropdown.vue";
import DropdownLink from "./DropdownLink.vue";

export default {
    data() {
        return {
            authenticated: usePage().props.auth.authenticated,
            user: usePage().props.auth.user,
            notifications: usePage().props.auth.user?.get_notifications,
            unreaded_notifications: usePage().props.auth.unreaded_notifications,
            chats: {},
            cats: {},

            showBullChats: false,
        };
    },
    props: {
        categories: Object,
    },
    components: {
        Link,
        Dropdown,
        DropdownLink,
    },
    methods: {
        navbar() {
            document.getElementById("nn").classList.toggle("activeNavBar");
        },
        readNotification(id) {
            router.post(route("notifications.read", { id }));
        },
    },
    mounted() {
        if (this.authenticated) {
            axios
                .post(route("api.chats"))
                .then((response) => {
                    this.chats = response.data.chats;
                    this.showBullChats = response.data.showBullChats;
                })
                .catch((error) => {
                    // console.log(error);
                });
        }

        if (!this.categories) {
            axios
                .post(route("get-cats"))
                .then((response) => {
                    this.cats = response.data.categories;
                })
                .catch((error) => {
                    // console.log(error);
                });
        }
    },
};
</script>

<template>
    <nav class="bg-primary-dark fixed w-full top-0 left-0 z-[100]">
        <div
            class="max-w-screen-xl flex items-center justify-between mx-auto px-4"
        >
            <div class="hidden md:flex items-center" id="nn">
                <a href="/" class="block w-32 mx-2">
                    <img
                        src="/storage/images/logo.png"
                        class="w-auto mr-3"
                        alt="Flowbite Logo"
                    />
                </a>

                <div class="mx-2">
                    <Dropdown align="right">
                        <template #trigger>
                            <button
                                type="button"
                                class="h-full text-white font-medium text-md py-4 px-2 text-center hover:bg-primary-light duration-100 flex w-max items-center"
                            >
                                <font-awesome-icon icon="cubes" />
                                <span class="mx-1"> التصنيفات </span>
                            </button>
                        </template>

                        <template #content>
                            <ul
                                class="py-2 text-sm text-gray-700 dark:text-gray-400"
                            >
                                <li
                                    v-for="category in categories ?? cats"
                                    :key="category.id"
                                >
                                    <DropdownLink
                                        :href="
                                            route('category', {
                                                slug: category.slug,
                                            })
                                        "
                                    >
                                        <span
                                            v-text="category.name"
                                            class="mx-2"
                                        ></span>
                                    </DropdownLink>
                                </li>
                            </ul>
                        </template>
                    </Dropdown>
                </div>
                <div class="mx-2">
                    <Link
                        v-if="authenticated"
                        :href="route('gigs.create')"
                        class="text-white font-medium text-md py-4 px-2 text-center hover:bg-primary-light duration-100 flex w-max items-center"
                    >
                        <font-awesome-icon icon="plus" />
                        <span class="mx-1"> اضافة خدمة </span>
                    </Link>
                </div>
                <div class="mx-2">
                    <Link
                        v-if="authenticated"
                        :href="route('purchases')"
                        class="text-white font-medium text-md py-4 px-2 text-center hover:bg-primary-light duration-100 flex w-max items-center"
                    >
                        <font-awesome-icon icon="bag-shopping" />
                        <span class="mx-1"> المشتريات </span>
                    </Link>
                </div>
                <div class="mx-2">
                    <Link
                        v-if="authenticated"
                        :href="route('orders')"
                        class="text-white font-medium text-md py-4 px-2 text-center hover:bg-primary-light duration-100 flex w-max items-center relative"
                    >
                        <div
                            v-if="$page.props.auth.pending_orders > 0"
                            class="block absolute bg-red-600 w-2 h-2 top-3 left-3 rounded-full"
                        ></div>
                        <font-awesome-icon icon="basket-shopping" />
                        <span class="mx-1"> الطلبات الواردة </span>
                    </Link>
                </div>
            </div>
            <div
                class="flex items-center justify-between md:justify-end w-full"
            >
                <button
                    data-collapse-toggle="navbar-default"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-default"
                    aria-expanded="false"
                    @click.prevent="navbar"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-6 h-6"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
                <div class="flex items-center">
                    <div class="mx-2">
                        <Link
                            v-if="!authenticated"
                            :href="route('login')"
                            class="text-white border-1 border-white font-medium rounded-sm text-md px-4 py-2 text-center"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'arrow-right-to-bracket']"
                            />
                            <span class="mx-1"> دخول </span>
                        </Link>
                    </div>
                    <div class="mx-2">
                        <Link
                            v-if="!authenticated"
                            :href="route('register')"
                            class="text-white border-1 border-white font-medium rounded-sm text-md px-4 py-2 text-center"
                        >
                            <font-awesome-icon :icon="['fas', 'user-plus']" />
                            <span class="mx-1"> حساب جديد </span>
                        </Link>
                    </div>
                    <div class="mx-2">
                        <Link
                            :href="route('cart')"
                            class="h-full text-white font-medium text-md py-4 px-4 text-center hover:bg-primary-light duration-100 block"
                        >
                            <font-awesome-icon icon="cart-shopping" />
                        </Link>
                    </div>
                    <div class="mx-2" v-if="authenticated">
                        <Dropdown align="left" width="80">
                            <template #trigger>
                                <button
                                    type="button"
                                    class="h-full text-white font-medium text-md py-4 px-4 text-center hover:bg-primary-light duration-100 block relative"
                                >
                                    <div
                                        v-if="showBullChats"
                                        class="block absolute bg-red-600 w-2 h-2 top-4 left-3 rounded-full"
                                    ></div>
                                    <font-awesome-icon icon="envelope" />
                                </button>
                            </template>

                            <template #content>
                                <div
                                    v-if="chats.length > 0"
                                    class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-auto"
                                >
                                    <div v-for="chat in chats">
                                        <a
                                            v-if="chat.message"
                                            :href="
                                                route('chats.message', {
                                                    chat: chat.id,
                                                })
                                            "
                                            class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <div class="flex-shrink-0">
                                                <img
                                                    v-if="
                                                        chat.user_one.id ==
                                                        user.id
                                                    "
                                                    class="rounded-full w-11 h-11"
                                                    :src="`/storage/images/users/${chat.user_one.thumbnail}`"
                                                />
                                                <img
                                                    v-else-if="
                                                        chat.user_two.id ==
                                                        user.id
                                                    "
                                                    class="rounded-full w-11 h-11"
                                                    :src="`/storage/images/users/${chat.user_two.thumbnail}`"
                                                />
                                            </div>
                                            <div class="w-full pr-3 relative">
                                                <div
                                                    v-if="
                                                        chat.user_one.id ==
                                                        user.id
                                                    "
                                                >
                                                    {{ chat.user_one.name }}
                                                </div>
                                                <div v-else>
                                                    {{ chat.user_two.name }}
                                                </div>
                                                <div
                                                    class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"
                                                    v-text="
                                                        chat.message.content
                                                    "
                                                ></div>
                                                <div
                                                    class="text-xs text-blue-600 dark:text-blue-500 absolute left-1 bottom-0"
                                                    v-text="
                                                        chat.message
                                                            .formated_created_at
                                                    "
                                                ></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div v-else class="p-4">لا توجد دردشة</div>
                            </template>
                        </Dropdown>
                    </div>
                    <div class="mx-2" v-if="authenticated">
                        <Dropdown align="left" width="80">
                            <template #trigger>
                                <button
                                    type="button"
                                    class="h-full text-white font-medium text-md py-4 px-4 text-center hover:bg-primary-light duration-100 block relative"
                                >
                                    <div
                                        v-if="unreaded_notifications"
                                        class="block absolute bg-red-600 w-2 h-2 top-4 left-4 rounded-full"
                                    ></div>
                                    <font-awesome-icon icon="bell" />
                                </button>
                            </template>

                            <template #content>
                                <div
                                    class="max-h-80 overflow-auto"
                                    v-if="notifications.length > 0"
                                >
                                    <div
                                        class="divide-y divide-gray-100 dark:divide-gray-700"
                                    >
                                        <div
                                            class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            v-for="notification in notifications"
                                        >
                                            <div class="flex-shrink-0">
                                                <img
                                                    class="rounded-full w-11 h-11"
                                                    :src="`/storage/images/users/${user.thumbnail}`"
                                                />
                                            </div>
                                            <div class="w-full pr-3">
                                                <div
                                                    class="text-gray-500 text-sm mb-1.5 dark:text-gray-400 relative"
                                                >
                                                    <!-- <a
                                                        :href="route('orders')"
                                                        v-if="
                                                            notification.data
                                                                .order
                                                        "
                                                    >
                                                        {{
                                                            $t(
                                                                "message." +
                                                                    notification
                                                                        .data
                                                                        .message
                                                            )
                                                        }}
                                                    </a>
                                                    <a
                                                        v-else-if="
                                                            notification.data
                                                                .gig
                                                        "
                                                        :href="
                                                            route('gigs.index')
                                                        "
                                                    >
                                                        <div>
                                                            {{
                                                                $t(
                                                                    "message." +
                                                                        notification
                                                                            .data
                                                                            .message
                                                                )
                                                            }}
                                                        </div>
                                                        <div
                                                            v-if="
                                                                notification
                                                                    .data.gig
                                                            "
                                                        >
                                                            {{
                                                                notification
                                                                    .data.gig
                                                            }}
                                                        </div>
                                                        <div
                                                            v-if="
                                                                notification
                                                                    .data
                                                                    .sub_message
                                                            "
                                                        >
                                                            {{
                                                                notification
                                                                    .data
                                                                    .sub_message
                                                            }}
                                                        </div>
                                                    </a>
                                                    <span v-else>{{
                                                        $t(
                                                            "message." +
                                                                notification
                                                                    .data
                                                                    .message
                                                        )
                                                    }}</span> -->
                                                    <Link
                                                        :href="
                                                            notification.data
                                                                .link
                                                        "
                                                        v-if="
                                                            notification.read_at
                                                        "
                                                    >
                                                        {{
                                                            notification.data
                                                                .message
                                                        }}
                                                    </Link>
                                                    <Link
                                                        :href="
                                                            route(
                                                                'notifications.read',
                                                                {
                                                                    id: notification.id,
                                                                }
                                                            )
                                                        "
                                                        v-else
                                                    >
                                                        {{
                                                            notification.data
                                                                .message
                                                        }}
                                                    </Link>
                                                    <!-- <div
                                                        v-if="
                                                            !notification.read_at
                                                        "
                                                        @click.prevent="
                                                            readNotification(
                                                                notification.id
                                                            )
                                                        "
                                                        class="block absolute bg-green-600 w-3 h-3 top-4 left-1 rounded-full cursor-pointer"
                                                    ></div> -->
                                                </div>
                                                <div
                                                    class="text-xs text-blue-600 dark:text-blue-500 z-50"
                                                    v-text="
                                                        notification.formated_created_at
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4" v-else>
                                    لا توجد أية اشعارات
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                    <div class="mx-2" v-if="authenticated">
                        <Dropdown align="left">
                            <template #trigger>
                                <span class="flex items-center rounded-md">
                                    <button type="button" class="h-full flex">
                                        <img
                                            :src="
                                                '/storage/images/users/' +
                                                user.thumbnail
                                            "
                                            class="w-10 h-10 rounded-full"
                                        />
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink
                                    :href="
                                        route('user', {
                                            username: user.username,
                                        })
                                    "
                                >
                                    <font-awesome-icon icon="user" />
                                    <span
                                        v-text="user.username"
                                        class="mx-2"
                                    ></span>
                                </DropdownLink>
                                <DropdownLink :href="route('credit')">
                                    <font-awesome-icon icon="dollar-sign" />
                                    <span class="mx-2"> الرصيد </span>
                                </DropdownLink>
                                <!-- <DropdownLink :href="route('cart')">
                                <font-awesome-icon icon="cogs" />
                                <span class="mx-2"> الاعدادات </span>
                            </DropdownLink> -->
                                <hr />
                                <DropdownLink :href="route('profile')">
                                    <font-awesome-icon icon="pen-to-square" />
                                    <span class="mx-2"> تعديل الحساب </span>
                                </DropdownLink>
                                <DropdownLink :href="route('support')">
                                    <font-awesome-icon icon="life-ring" />
                                    <span class="mx-2"> مساعدة </span>
                                </DropdownLink>
                                <hr />
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    <font-awesome-icon
                                        icon="arrow-right-to-bracket"
                                    />
                                    <span class="mx-2">خروج</span>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style>
.activeNavBar {
    position: absolute;
    top: 0;
    background: #0b2447;
    display: block;
    right: 0;
    top: 55px;
}
</style>
