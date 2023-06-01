<script>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    data() {
        return {
            form: useForm({
                status: "pending",
                title: null,
                description: null,
                delivery_time: 1,
                instructions: null,
                price: null,
                language: "ar",
                user: null,
                user_id: null,
                category: null,
                thumbnails: [],
                extras: [],
            }),
            users: {},
            errors: [],
            url: URL,
            timer: null,
        };
    },
    props: {
        categories: Object,
        prices: Object,
        times: Object,
        extras_prices: Object,
        extras_times: Object,
        sts: Object,
        languages: Object,
    },
    components: {
        InputError,
        InputLabel,
        AdminLayout,
    },
    methods: {
        create() {
            this.form.extras = this.cextras;

            this.form.post(route("admin.gigs.store"), {
                preserveScroll: true,
                onError: (errors) => {
                    this.errors = errors;
                    console.log(this.errors);
                },
            });
        },
        uploadFile() {
            let files = document.getElementById("dropzone-file").files;
            for (let i = 0; i < files.length; i++) {
                this.form.thumbnails.push(files[i]);
            }
        },
        deleteThumbnail(index) {
            this.form.thumbnails.splice(index, 1);
        },
        addExtra() {
            this.form.extras.push({
                title: null,
                price: 5,
                increased_time: "yes",
                time: 1,
            });
        },
        deleteExtra(index) {
            this.form.extras.splice(index, 1);
        },
        searchUser(event) {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                axios
                    .post(route("api.get-users"), {
                        search: event.target.value,
                    })
                    .then((response) => {
                        this.users = response.data.users;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }, 800);
        },
        selectUser(id, name) {
            this.users = [];
            this.form.user = name;
            this.form.user_id = id;
        },
    },
    computed: {
        cextras() {
            const results = this.form.extras.map((extra) => {
                return {
                    title: extra.title,
                    price: extra.price,
                    increased_time: extra.increased_time,
                    time: extra.time,
                };
            });
            return results;
        },
    },
};
</script>

<template>
    <AdminLayout>
        <div class="w-full md:w-3/4 mx-auto p-4 bg-white">
            <form
                @submit.prevent="create"
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
                            v-for="(status, id) in sts"
                            :key="id"
                            v-text="status"
                            :value="id"
                        ></option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.status" />
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

                <div class="mb-4 col-span-2">
                    <InputLabel
                        for="description"
                        :value="$t('message.description')"
                    />

                    <textarea
                        id="description"
                        class="border-gray-500 rounded-sm shadow-sm w-full h-60"
                        v-model="form.description"
                    ></textarea>

                    <InputError
                        class="mt-2"
                        :message="form.errors.description"
                    />
                </div>

                <div class="mb-4 col-span-2">
                    <InputLabel for="thumbnails" value="معرض الخدمة" />

                    <div class="flex items-center justify-center w-full mt-2">
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
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400"
                                >
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
                    </div>
                    <span class="block mt-2 text-base text-gray-500"
                        >أضف صور بشكل جيد لتظهر خدمتك بشكل احترافي وتزيد من
                        مبيعاتك.</span
                    >

                    <div
                        v-if="form.thumbnails.length > 0"
                        class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4"
                    >
                        <div
                            v-for="(image, index) in form.thumbnails"
                            class="relative"
                        >
                            <button
                                type="button"
                                @click.prevent="deleteThumbnail(index)"
                                class="w-8 h-8 flex justify-center items-center font-bold text-xl text-white bg-red-500 absolute top-2 left-2 cursor-pointer rounded-full"
                            >
                                x
                            </button>
                            <img
                                class="h-40 w-full rounded-lg"
                                :src="url.createObjectURL(image)"
                            />
                        </div>
                    </div>

                    <InputError
                        class="mt-2"
                        :message="form.errors.description"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="delivery_time"
                        :value="$t('message.delivery_time')"
                    />

                    <select
                        id="delivery_time"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.delivery_time"
                    >
                        <option
                            v-for="(time, index) in times"
                            :key="'time-' + index"
                            v-text="time"
                            :value="index"
                        ></option>
                    </select>

                    <InputError
                        class="mt-2"
                        :message="form.errors.delivery_time"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="category" value="التصنيف" />

                    <select
                        id="category"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.category"
                    >
                        <option
                            v-for="category in categories"
                            :key="'cat-' + category.id"
                            v-text="category.name"
                            :value="category.id"
                        ></option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.category" />
                </div>

                <div class="mb-4 col-span-2">
                    <InputLabel
                        for="instructions"
                        :value="$t('message.instructions')"
                    />

                    <textarea
                        id="instructions"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.instructions"
                    ></textarea>

                    <InputError
                        class="mt-2"
                        :message="form.errors.instructions"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="price" :value="$t('message.price')" />

                    <select
                        id="price"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.price"
                    >
                        <option
                            v-for="(price, index) in prices"
                            :key="'price-' + index"
                            v-text="price"
                            :value="index"
                        ></option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.price" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="language"
                        :value="$t('message.language')"
                    />

                    <select
                        id="language"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="form.language"
                    >
                        <option
                            v-for="(language, index) in languages"
                            :key="'language-' + index"
                            v-text="language"
                            :value="index"
                        ></option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.language" />
                </div>

                <div class="mb-4 col-span-2">
                    <InputLabel for="user" :value="$t('message.user')" />

                    <div class="relative">
                        <input
                            type="text"
                            step="0.01"
                            id="user"
                            class="border-gray-500 rounded-sm shadow-sm w-full"
                            v-model="form.user"
                            v-on:keyup="searchUser"
                        />
                        <div
                            vif="users.length > 0"
                            class="absolute bg-gray-100 w-full"
                        >
                            <a
                                href="#"
                                class="block p-4 w-full hover:bg-gray-200 duration-100"
                                v-for="(name, id) in users"
                                v-text="name"
                                @click.prevent="selectUser(id, name)"
                            >
                            </a>
                        </div>
                    </div>

                    <InputError class="mt-2" :message="form.errors.user" />
                </div>

                <div class="mb-4 flex justify-end col-span-2">
                    <button
                        type="button"
                        @click="addExtra()"
                        class="py-2 px-4 bg-white border border-primary-light text-primary-dark duration-100 hover:text-white hover:bg-primary-light"
                    >
                        <span> أضف تطويرا لهذه الخدمة </span>
                        <span>
                            <font-awesome-icon icon="plus" />
                        </span>
                    </button>
                </div>

                <div class="mb-4 col-span-2" v-if="form.extras.length > 0">
                    <div
                        class="p-4 mx-4 bg-gray-50 relative"
                        v-for="(extra, index) in cextras"
                        :key="extra"
                    >
                        <button
                            type="button"
                            @click="deleteExtra(index)"
                            class="w-6 h-6 bg-gray-500 font-bold text-white rounded-full flex justify-center items-center -left-3 -top-3 absolute"
                        >
                            X
                        </button>
                        <div class="mb-4">
                            <input
                                type="text"
                                :id="'title-' + index"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                v-model="extra.title"
                            />
                            <span class="block mt-2 text-base text-gray-500"
                                >تطويرات الخدمة المقدمة اختيارية فقط ولا يمكن أن
                                تجبر المشتري على طلبها. اعرف طريقة استخدامها
                                بشكل صحيح</span
                            >

                            <InputError
                                class="mt-2"
                                :message="errors['extras.' + index + '.title']"
                            />
                        </div>
                        <div class="mb-4">
                            <select
                                :id="'price-' + index"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                v-model="extra.price"
                            >
                                <option
                                    v-for="(price, index) in extras_prices"
                                    :key="'cat-' + price"
                                    v-text="price"
                                    :value="index"
                                ></option>
                            </select>

                            <InputError
                                class="mt-2"
                                :message="errors['extras.' + index + '.price']"
                            />
                        </div>
                        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <select
                                    :id="'time-' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full"
                                    v-model="extra.increased_time"
                                >
                                    <option
                                        v-for="(time, index) in extras_times"
                                        :key="'cat-' + index"
                                        v-text="time"
                                        :value="index"
                                    ></option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="
                                        errors[
                                            'extras.' +
                                                index +
                                                '.increased_time'
                                        ]
                                    "
                                />
                            </div>
                            <div>
                                <select
                                    :id="'etime-' + index"
                                    class="border-gray-500 rounded-sm shadow-sm w-full"
                                    v-model="extra.time"
                                >
                                    <option
                                        v-for="(time, index) in times"
                                        :key="'time-' + index"
                                        v-text="time"
                                        :value="index"
                                    ></option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="
                                        errors['extras.' + index + '.time']
                                    "
                                />
                            </div>
                        </div>
                    </div>
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
