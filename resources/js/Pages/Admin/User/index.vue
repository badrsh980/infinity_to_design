<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Alert from "@/Components/Alert.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    props: {
        users: Object,
    },
    components: {
        AdminLayout,
        Link,
        Alert,
        Pagination,
    },
    methods: {
        delete(id) {
            router.delete(route("admin.users.destroy", { user: id }), {
                onError(r) {
                    console.log(r);
                },
            });
        },
    },
    mounted() {
        // console.log(this.users);
    },
};
</script>

<template>
    <AdminLayout>
        <div class="mt-12 p-6 bg-gray-50">
            <div class="my-6 flex justify-between items-center">
                <div></div>
                <div>
                    <a
                        class="py-2 px-4 font-normal text-base bg-primary-light text-white rounded-md"
                        :href="route('admin.users.create')"
                        >{{ $t("message.add") }}</a
                    >
                </div>
            </div>
            <div class="my-6">
                <Alert :message="$page.props.flash.message" />
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.id") }}
                                </th>
                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.status") }}
                                </th>
                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.username") }}
                                </th>
                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.email") }}
                                </th>
                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.name") }}
                                </th>
                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.specialization") }}
                                </th>

                                <th scope="col" class="py-4 px-6">
                                    {{ $t("message.options") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="user in users.data"
                            >
                                <td class="py-4 px-6" v-text="user.id"></td>
                                <td
                                    class="py-4 px-6"
                                    v-text="user.tr_status"
                                ></td>
                                <td
                                    class="py-4 px-6"
                                    v-text="user.username"
                                ></td>
                                <td class="py-4 px-6" v-text="user.email"></td>
                                <td class="py-4 px-6" v-text="user.name"></td>
                                <td
                                    class="py-4 px-6"
                                    v-text="user.specialization"
                                ></td>

                                <td class="py-4 px-6">
                                    <a
                                        :href="
                                            route('admin.users.edit', {
                                                user: user.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.edit") }}</a
                                    >
                                    <a
                                        :href="
                                            route('admin.users.show', {
                                                user: user.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.show") }}</a
                                    >
                                    <button
                                        type="button"
                                        @click="this.delete(user.id)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        {{ $t("message.delete") }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :model="users" />
            </div>
        </div>
    </AdminLayout>
</template>
