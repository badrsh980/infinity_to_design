<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        messages: Object,
    },
    components: {
        AdminLayout,
        Link,
    },
    methods: {
        delete(id) {
            router.delete(route("admin.messages.destroy", { message: id }));
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
                        :href="route('admin.messages.create')"
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
                                    {{ $t("message.name") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.email") }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.subject") }}
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    {{ $t("message.options") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="message in messages.data"
                            >
                                <td
                                    class="px-6 py-4"
                                    v-text="message.name"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="message.email"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="message.subject"
                                ></td>

                                <td class="px-6 py-4">
                                    <!-- <a
                                        :href="
                                            route('admin.messages.edit', {
                                                message: message.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.edit") }}</a
                                    > -->
                                    <a
                                        :href="
                                            route('admin.messages.show', {
                                                message: message.id,
                                            })
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                        >{{ $t("message.show") }}</a
                                    >
                                    <button
                                        type="button"
                                        @click="this.delete(message.id)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        {{ $t("message.delete") }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
