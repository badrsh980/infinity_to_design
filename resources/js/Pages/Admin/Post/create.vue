<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    data() {
        return {
            form: useForm({
                title: null,
                content: "",
                is_post: "yes",
            }),
            editor: ClassicEditor,
            editorConfig: {
                language: "ar",
            },
        };
    },
    props: { status: Object },
    components: {
        InputError,
        InputLabel,
        AdminLayout,
        ckeditor: CKEditor.component,
    },
    methods: {
        create() {
            this.form.post(route("admin.posts.store"), {
                preserveScroll: true,
                onError: (errors) => {
                    // console.log(errors);
                },
            });
        },
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-full md:w-3/4 mx-auto p-4 bg-white">
            <form @submit.prevent="create">
                <div class="mb-4">
                    <InputLabel for="is_post" :value="$t('message.is_post')" />

                    <select
                        id="is_post"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.is_post"
                    >
                        <option
                            v-for="(status, key) in status"
                            :key="key"
                            v-text="status"
                            :value="key"
                        ></option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.is_post" />
                </div>

                <div class="mb-4">
                    <InputLabel for="title" :value="$t('message.title')" />

                    <input
                        type="text"
                        id="title"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.title"
                    />

                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div class="mb-4">
                    <InputLabel for="content" :value="$t('message.content')" />

                    <ckeditor
                        :editor="editor"
                        v-model="form.content"
                        :config="editorConfig"
                    ></ckeditor>

                    <InputError class="mt-2" :message="form.errors.content" />
                </div>

                <div class="mb-4">
                    <button
                        class="py-2 px-4 border bg-primary-light text-white rounded-md"
                    >
                        <span>{{ $t("message.submit") }}</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<style>
.ck.ck-editor__main > .ck-editor__editable {
    height: 400px;
    direction: rtl;
    text-align: right;
}
</style>
