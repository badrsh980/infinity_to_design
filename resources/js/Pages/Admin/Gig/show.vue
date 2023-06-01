<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        gig: Object,
        languages: Object,
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
                            <td class="px-6 py-4">{{ gig.id }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.status") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.tr_status }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.title") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.title }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.description") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.description }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.thumbnails") }}
                            </th>
                            <td class="px-6 py-4">
                                <div
                                    class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4"
                                >
                                    <div
                                        v-for="(image, index) in gig.thumbnails"
                                        class="relative"
                                    >
                                        <img
                                            class="h-40 w-full rounded-lg"
                                            :src="
                                                '/storage/images/gigs/' + image
                                            "
                                        />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.delivery_time") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.time_formated }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.instructions") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.instructions }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.price") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.price_formated }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.user_changes") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.user_changes }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.language") }}
                            </th>
                            <td class="px-6 py-4">
                                {{ languages[gig.language] }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.user") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.user.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.category") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.category.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.created_at") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.created_date }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.updated_at") }}
                            </th>
                            <td class="px-6 py-4">{{ gig.updated_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
