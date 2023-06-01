<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        user: Object,
    },
    components: {
        AdminLayout,
        Link,
    },
};
</script>

<template>
    <AdminLayout>
        <div class="mt-12 p-6 bg-gray-50">
            <div class="my-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.id") }}
                            </th>
                            <td class="px-6 py-4">{{ user.id }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.status") }}
                            </th>
                            <td class="px-6 py-4">{{ user.tr_status }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.username") }}
                            </th>
                            <td class="px-6 py-4">{{ user.username }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.email") }}
                            </th>
                            <td class="px-6 py-4">{{ user.email }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.name") }}
                            </th>
                            <td class="px-6 py-4">{{ user.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.address") }}
                            </th>
                            <td class="px-6 py-4">{{ user.address }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.state") }}
                            </th>
                            <td class="px-6 py-4">{{ user.state }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.city") }}
                            </th>
                            <td class="px-6 py-4">{{ user.city }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.post_code") }}
                            </th>
                            <td class="px-6 py-4">{{ user.post_code }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.country") }}
                            </th>
                            <td class="px-6 py-4">{{ user.country }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.thumbnail") }}
                            </th>
                            <td class="px-6 py-4">
                                <div
                                    class="flex justify-center items-center cursor-pointer rounded-full w-32 h-32 overflow-hidden mx-auto relative"
                                >
                                    <img
                                        class="w-full h-full"
                                        :src="
                                            '/storage/images/users/' +
                                            user.thumbnail
                                        "
                                    />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.description") }}
                            </th>
                            <td class="px-6 py-4">{{ user.description }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.last_seen") }}
                            </th>
                            <td class="px-6 py-4">{{ user.last_seen }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.response_time") }}
                            </th>
                            <td class="px-6 py-4">{{ user.response_time }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.balance") }}
                            </th>
                            <td class="px-6 py-4">{{ user.balance }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.withdrawal_email") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ user.withdrawal_email }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.withdrawal_method") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ user.withdrawal_method }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.email_verified_at") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ user.email_verified_at_date }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.specialization") }}
                            </th>
                            <td class="px-6 py-4">{{ user.specialization }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.created_at") }}
                            </th>
                            <td class="px-6 py-4">{{ user.created_date }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.updated_at") }}
                            </th>
                            <td class="px-6 py-4">{{ user.updated_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
