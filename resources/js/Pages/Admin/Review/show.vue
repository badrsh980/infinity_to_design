<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import RateStars from "@/Components/RateStars.vue";

export default {
    props: {
        review: Object,
    },
    components: {
        AdminLayout,
        Link,
        RateStars,
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
                            <td class="px-6 py-4">{{ review.id }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.content") }}
                            </th>
                            <td class="px-6 py-4">{{ review.content }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.reply") }}
                            </th>
                            <td class="px-6 py-4">{{ review.reply }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.user") }}
                            </th>
                            <td class="px-6 py-4">{{ review.user.name }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.gig") }}
                            </th>
                            <td class="px-6 py-4">{{ review.gig?.title }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.created_at") }}
                            </th>
                            <td class="px-6 py-4">{{ review.created_date }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.updated_at") }}
                            </th>
                            <td class="px-6 py-4">{{ review.updated_date }}</td>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t("message.rates") }}
                            </th>
                            <td class="px-6 py-4">
                                <div
                                    class="p-4 flex justify-between"
                                    v-for="rate in review.rates"
                                >
                                    <RateStars :avg="rate.count" />
                                    <span v-text="rate.tr_name"></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
