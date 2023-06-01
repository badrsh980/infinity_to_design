<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            form: useForm({
                name: null,
                thumbnail: null,
            }),
            url: URL,
        };
    },
    props: {
        category: Object,
    },
    components: {
        InputError,
        InputLabel,
        AdminLayout,
    },
    methods: {
        uploadFile() {
            let file = document.getElementById("dropzone-file").files[0];
            this.form.thumbnail = file;
        },
        update() {
            this.form.post(
                route("admin.categories.update", {
                    category: this.category.id,
                }),
                {
                    preserveScroll: true,
                    onError: (errors) => {
                        console.log(errors);
                    },
                }
            );
        },
    },
    mounted() {
        this.form.name = this.category.name;
        this.form.thumbnail = this.category.thumbnail;
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-full md:w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="update">
                <div class="mb-4">
                    <InputLabel for="name" :value="$t('message.name')" />

                    <input
                        type="text"
                        id="name"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="thumbnail" :value="$t('message.image')" />

                    <label
                        for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                    >
                        <div
                            class="flex flex-col items-center justify-center pt-5 pb-6"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-10 h-10 mb-3 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                ></path>
                            </svg>
                            <p
                                class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                            >
                                <span class="font-semibold"
                                    >Click to upload</span
                                >
                                or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                SVG, PNG, JPG or GIF (MAX. 800x400px)
                            </p>
                        </div>
                        <input
                            id="dropzone-file"
                            type="file"
                            class="hidden"
                            @change="uploadFile"
                            multiple="multiple"
                        />
                    </label>

                    <div
                        v-if="form.thumbnail"
                        class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4"
                    >
                        <img
                            v-if="typeof form.thumbnail == 'string'"
                            class="h-40 w-full rounded-lg"
                            :src="'/storage/images/' + form.thumbnail"
                        />
                        <img
                            v-else-if="typeof form.thumbnail == 'object'"
                            class="h-40 w-full rounded-lg"
                            :src="url.createObjectURL(form.thumbnail)"
                        />
                    </div>

                    <InputError class="mt-2" :message="form.errors.thumbnail" />
                </div>

                <div class="mb-4">
                    <button
                        class="py-2 px-4 border bg-primary-light text-white"
                    >
                        <span>{{ $t("message.submit") }}</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
