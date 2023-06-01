<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    props: {
        reviews: Object,
    },
    components: {
        AdminLayout,
        Link,
        Pagination,
    },
    methods: {
        delete(id) {
            router.delete(route("admin.reviews.destroy", { review: id }));
        },
    },
};
</script>

<template>
    <AdminLayout>
        <div class="mt-12 p-6 bg-gray-50">
            <!-- <div class="my-6 flex justify-between items-center">
                <div></div>
                <div>
                    <a
                        class="p-4 font-normal text-base bg-primary-light text-white"
                        :href="route('admin.reviews.create')"
                        >{{ $t("message.add") }}</a
                    >
                </div>
            </div> -->
            <div class="my-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.id") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.content") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.user") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.gig") }}
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.options") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="review in reviews.data"
                            >
                                <td class="px-6 py-4" v-text="review.id"></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="review.content"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="review.user.name"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="review.gig?.title"
                                ></td>

                                <td class="px-6 py-4">
                                    <!-- <a
                                        :href="
                                            route('admin.reviews.edit', {
                                                review: review.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.edit") }}</a
                                    > -->
                                    <a
                                        :href="
                                            route('admin.reviews.show', {
                                                review: review.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.show") }}</a
                                    >
                                    <button
                                        type="button"
                                        @click="this.delete(review.id)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        {{ $t("message.delete") }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :model="reviews" />
            </div>
        </div>
    </AdminLayout>
</template>
