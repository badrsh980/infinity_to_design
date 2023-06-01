<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Alert from "@/Components/Alert.vue";

export default {
    data() {
        return {
            form: useForm({
                status: null,
                username: null,
                email: null,
                password: null,
                password_confirmation: null,
                name: null,
                thumbnail: null,
                description: null,
                specialization: null,
            }),
            preview: null,
        };
    },
    props: {
        user: Object,
        sts: Object,
    },
    components: {
        InputError,
        InputLabel,
        Alert,
        AdminLayout,
    },
    methods: {
        update() {
            this.form.patch(
                route("admin.users.update", { user: this.user.id }),
                {
                    preserveScroll: true,
                    onError: (errors) => {
                        console.log(errors);
                    },
                }
            );
        },
        thumbnail() {
            var image = document.getElementById("thumbnail").files[0];
            this.preview = URL.createObjectURL(image);
            this.form.thumbnail = image;
        },
    },
    mounted() {
        this.form.status = this.user.status;
        this.form.username = this.user.username;
        this.form.email = this.user.email;
        this.form.password = this.user.password;
        this.form.name = this.user.name;
        this.preview = "/storage/images/users/" + this.user.thumbnail;
        this.form.description = this.user.description;
        this.form.specialization = this.user.specialization;
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-full md:w-3/4 mx-auto p-4 bg-white">
            <Alert :message="$page.props.flash.message" />
            <form
                @submit.prevent="update"
                class="block md:grid grid-cols-1 lg:grid-cols-2 gap-4"
            >
                <div class="mb-4">
                    <InputLabel for="status" :value="$t('message.status')" />

                    <select
                        id="status"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.status"
                    >
                        <option
                            v-for="(s, n) in sts"
                            :value="n"
                            v-text="s"
                        ></option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.status" />
                </div>

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
                    <InputLabel
                        for="username"
                        :value="$t('message.username')"
                    />

                    <input
                        type="text"
                        id="username"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.username"
                    />

                    <InputError class="mt-2" :message="form.errors.username" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" :value="$t('message.email')" />

                    <input
                        type="text"
                        id="email"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.email"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="password"
                        :value="$t('message.password')"
                    />

                    <input
                        type="text"
                        id="password"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="password_confirmation"
                        :value="$t('message.password_confirmation')"
                    />

                    <input
                        type="text"
                        id="password_confirmation"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.password_confirmation"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div class="mb-4 col-span-2">
                    <InputLabel
                        for="specialization"
                        :value="$t('message.specialization')"
                    />

                    <input
                        type="text"
                        id="specialization"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.specialization"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.specialization"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="thumbnail"
                        :value="$t('message.thumbnail')"
                    />

                    <label
                        for="thumbnail"
                        class="flex justify-center items-center cursor-pointer rounded-full w-32 h-32 overflow-hidden mx-auto relative"
                    >
                        <img class="w-full h-full" :src="preview" />
                        <div
                            class="w-full h-full bg-black bg-opacity-40 absolute top-0 left-0 flex justify-center items-center"
                        >
                            <font-awesome-icon
                                class="text-white text-xl"
                                :icon="['fas', 'camera']"
                            />
                        </div>
                        <input
                            type="file"
                            id="thumbnail"
                            class="hidden"
                            @change="thumbnail"
                        />
                    </label>

                    <InputError class="mt-2" :message="form.errors.thumbnail" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="description"
                        :value="$t('message.description')"
                    />

                    <textarea
                        id="description"
                        class="border-gray-500 rounded-sm shadow-sm w-full h-36"
                        v-model="form.description"
                    ></textarea>

                    <InputError
                        class="mt-2"
                        :message="form.errors.description"
                    />
                </div>

                <div class="mb-4 col-span-2">
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
