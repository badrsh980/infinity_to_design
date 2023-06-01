<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        order: Object,
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
                            <td class="px-6 py-4">{{ order.id }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.status") }}
                            </th>
                            <td class="px-6 py-4">{{ order.status }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.amount") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ order.price_formated }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.delivery_time") }}
                            </th>
                            <td class="px-6 py-4">{{ order.delivery_at }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.user") }}
                            </th>
                            <td class="px-6 py-4">{{ order.user.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.gig") }}
                            </th>
                            <td class="px-6 py-4">{{ order.gig.title }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.created_at") }}
                            </th>
                            <td class="px-6 py-4">{{ order.created_date }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.updated_at") }}
                            </th>
                            <td class="px-6 py-4">{{ order.updated_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
