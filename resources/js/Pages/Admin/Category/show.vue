<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        category: Object,
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
                            <td class="px-6 py-4">{{ category.id }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.name") }}
                            </th>
                            <td class="px-6 py-4">{{ category.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.image") }}
                            </th>
                            <td class="px-6 py-4">
                                <img
                                    :src="category.image"
                                    alt=""
                                    class="w-40"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.created_at") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ category.created_date }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.updated_at") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ category.updated_date }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
