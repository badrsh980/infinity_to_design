<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    props: {
        gigs: Object,
    },
    components: {
        AdminLayout,
        Link,
        Pagination,
    },
    methods: {
        delete(id) {
            router.delete(route("admin.gigs.destroy", { gig: id }));
        },
        approve(id) {
            router.get(route("admin.gigs.index"), {
                gig: id,
                page: "approve",
            });
        },
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
                        class="p-4 font-normal text-base bg-primary-light text-white rounded-md"
                        :href="route('admin.gigs.create')"
                        >{{ $t("message.add") }}</a
                    >
                </div>
            </div>
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
                                    {{ $t("message.status") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.title") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.delivery_time") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.price") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.user") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.category") }}
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.options") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="gig in gigs.data"
                            >
                                <td class="px-6 py-4" v-text="gig.id"></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.tr_status"
                                ></td>
                                <td class="px-6 py-4" v-text="gig.title"></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.time_formated"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.price_formated"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.user.name"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="gig.category.name"
                                ></td>

                                <td class="px-6 py-4">
                                    <a
                                        :href="
                                            route('admin.gigs.edit', {
                                                gig: gig.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.edit") }}</a
                                    >
                                    <a
                                        :href="
                                            route('admin.gigs.show', {
                                                gig: gig.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.show") }}</a
                                    >
                                    <button
                                        type="button"
                                        @click="this.delete(gig.id)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        {{ $t("message.delete") }}
                                    </button>
                                    <button
                                        v-if="gig.status == 'pending'"
                                        type="button"
                                        @click="this.approve(gig.id)"
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline mx-1"
                                    >
                                        {{ $t("message.approve") }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :model="gigs" />
            </div>
        </div>
    </AdminLayout>
</template>
