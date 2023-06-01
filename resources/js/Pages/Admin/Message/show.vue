<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        message: Object,
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
                            <td class="px-6 py-4">{{ message.id }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.name") }}
                            </th>
                            <td class="px-6 py-4">{{ message.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.email") }}
                            </th>
                            <td class="px-6 py-4">{{ message.email }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.subject") }}
                            </th>
                            <td class="px-6 py-4">{{ message.subject }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.message") }}
                            </th>
                            <td class="px-6 py-4">{{ message.message }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.readed") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $t("message." + message.readed) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.created_at") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ message.created_date }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.updated_at") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ message.updated_date }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
