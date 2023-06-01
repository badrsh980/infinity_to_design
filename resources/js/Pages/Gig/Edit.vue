<script>
import { Link, router, useForm } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

export default {
    data() {
        return {
            form: useForm({
                title: "",
                category: "",
                description: "",
                instructions: "",
                price: "",
                time: "",
                extras: [],
                thumbnails: [],
            }),
            errors: {},
            url: URL,
            extras: [],
        };
    },
    mounted() {
        this.form.title = this.gig.title;
        this.form.category = this.gig.category_id;
        this.form.description = this.gig.description;
        this.form.price = this.gig.price;
        this.form.time = this.gig.delivery_time;
        this.form.instructions = this.gig.instructions;
        this.form.thumbnails = this.gig.thumbnails;
        this.form.extras = this.gig.extras;
        this.gig.extras.forEach((extra, index) => {
            this.extras[index] = {
                increased_time: extra.change_gig_date,
            };
        });
    },
    props: {
        categories: Object,
        prices: Object,
        times: Object,
        extras_prices: Object,
        extras_times: Object,
        gig: Object,
    },
    components: {
        NavBar,
        Footer,
        InputError,
        InputLabel,
        Link,
    },
    methods: {
        uploadFile() {
            let files = document.getElementById("dropzone-file").files;
            Array.from(files).forEach((file) => {
                this.form.thumbnails.push(file);
            });
        },
        deleteThumbnail(index) {
            this.form.thumbnails.splice(index, 1);
        },
        addExtra() {
            this.form.extras.push({
                title: "",
                price: 5,
                increased_time: "yes",
                time: 1,
            });
        },
        deleteExtra(index) {
            router.post(
                route(
                    "gigs.delete-extra",
                    {
                        extra: this.form.extras[index]["id"],
                        gig: this.gig.id,
                    },
                    { preservEscroll: true }
                )
            );
            this.form.extras.splice(index, 1);
        },
        createGig() {
            this.form.extras = this.cextras;

            this.form.post(route("gigs.update", { gig: this.gig.id }));
        },
        changedTime(index) {
            var v = document.getElementById("increased-time" + index).value;
            this.extras[index] = {
                increased_time: v,
            };
        },
    },
    computed: {
        cextras() {
            const results = this.form.extras.map((extra) => {
                return {
                    id: extra.id ?? null,
                    title: extra.title,
                    price: extra.price,
                    increased_time: extra.change_gig_date,
                    time: extra.extra_time,
                };
            });
            return results;
        },
    },
};
</script>

<template>
    <NavBar class="mb-10" :categories="categories" />

    <div class="mt-12 p-6 bg-gray-50">
        <div class="max-w-screen-xl mx-auto">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a
                            href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-4 h-4 mx-2"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                                ></path>
                            </svg>
                            الصفحة الرئيسية
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <a
                            href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-6 h-6 text-gray-400 rotate-180"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            تعديل الخدمة
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="my-6 grid grid-cols-1 lg:grid-cols-4 gap-4">
                <div class="lg:col-span-3 p-4 bg-white">
                    <form @submit.prevent="createGig">
                        <div class="mb-4">
                            <InputLabel for="title" value="عنوان الخدمة" />

                            <input
                                type="text"
                                id="title"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                v-model="form.title"
                            />
                            <span class="block mt-2 text-base text-gray-500"
                                >أدخل عنواناً واضحاً باللغة العربية يصف الخدمة
                                التي تريد أن تقدمها. لا تدخل رموزاً أو كلمات مثل
                                "حصرياً"، "لأول مرة"، "لفترة محدود".. الخ.</span
                            >

                            <InputError
                                class="mt-2"
                                :message="form.errors.title"
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

                            <InputError
                                class="mt-2"
                                :message="form.errors.category"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="description" value="وصف الخدمة" />

                            <textarea
                                id="description"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                style="min-height: 250px"
                                v-model="form.description"
                            >
                            </textarea>
                            <span class="block mt-2 text-base text-gray-500"
                                >أدخل وصف الخدمة بدقة يتضمن جميع المعلومات
                                والشروط . يمنع وضع البريد الالكتروني، رقم الهاتف
                                أو أي معلومات اتصال أخرى.
                            </span>

                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="thumbnails" value="معرض الخدمة" />

                            <div
                                class="flex items-center justify-center w-full mt-2"
                            >
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
                                            SVG, PNG, JPG or GIF (MAX.
                                            800x400px)
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
                                >أضف صور بشكل جيد لتظهر خدمتك بشكل احترافي وتزيد
                                من مبيعاتك.</span
                            >

                            <div
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
                                        v-if="typeof image == 'string'"
                                        class="h-40 w-full rounded-lg"
                                        :src="'/storage/images/gigs/' + image"
                                    />
                                    <img
                                        v-else
                                        class="h-40 w-full rounded-lg"
                                        :src="url.createObjectURL(image)"
                                    />
                                </div>

                                <!-- <div
                                    v-for="(image, index) in old_thumbnails"
                                    class="relative"
                                >
                                    <button
                                        type="button"
                                        @click.prevent="
                                            deleteThumbnail(index, true)
                                        "
                                        class="w-8 h-8 flex justify-center items-center font-bold text-xl text-white bg-red-500 absolute top-2 left-2 cursor-pointer rounded-full"
                                    >
                                        x
                                    </button>
                                    <img
                                        class="h-40 w-full rounded-lg"
                                        :src="'/storage/images/gigs/' + image"
                                    />
                                </div> -->
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div>
                        <div class="mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel
                                        for="price"
                                        value="سعر الخدمة"
                                    />

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

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.price"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="time"
                                        value="مدة التسليم"
                                    />

                                    <select
                                        id="time"
                                        class="border-gray-500 rounded-sm shadow-sm w-full"
                                        v-model="form.time"
                                    >
                                        <option
                                            v-for="(time, index) in times"
                                            :key="'time-' + index"
                                            v-text="time"
                                            :value="index"
                                        ></option>
                                    </select>
                                    <span
                                        class="block mt-2 text-base text-gray-500"
                                    >
                                        يحق للمشتري إلغاء الخدمة مباشرة بحال
                                        التأخر عن الموعد المحدد.
                                    </span>

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.time"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <InputLabel
                                for="instructions"
                                value="تعليمات للمشتري"
                            />

                            <textarea
                                id="instructions"
                                class="border-gray-500 rounded-sm shadow-sm w-full"
                                style="min-height: 200px"
                                v-model="form.instructions"
                            >
                            </textarea>
                            <span class="block mt-2 text-base text-gray-500"
                                >المعلومات التي تحتاجها من المشتري لتنفيذ
                                الخدمة. تظهر هذه المعلومات بعد شراء الخدمة
                                فقط.</span
                            >

                            <InputError
                                class="mt-2"
                                :message="form.errors.instructions"
                            />
                        </div>
                        <div class="mb-4 flex justify-end">
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
                        <div class="mb-4" v-if="form.extras.length > 0">
                            <div
                                class="p-4 mx-4 bg-gray-50 relative my-4"
                                v-for="(extra, index) in cextras"
                                :key="extra"
                            >
                                <button
                                    type="button"
                                    @click="deleteExtra(index)"
                                    class="w-6 h-6 bg-red-500 font-bold text-white rounded-full flex justify-center items-center -left-2 -top-2 absolute"
                                >
                                    X
                                </button>
                                <div class="mb-4">
                                    <input
                                        type="text"
                                        :id="'title' + index"
                                        class="border-gray-500 rounded-sm shadow-sm w-full"
                                        v-model="extra.title"
                                    />
                                    <span
                                        class="block mt-2 text-base text-gray-500"
                                        >تطويرات الخدمة المقدمة اختيارية فقط ولا
                                        يمكن أن تجبر المشتري على طلبها. اعرف
                                        طريقة استخدامها بشكل صحيح</span
                                    >

                                    <InputError
                                        class="mt-2"
                                        :message="
                                            errors['extras.' + index + '.title']
                                        "
                                    />
                                </div>
                                <div class="mb-4">
                                    <select
                                        :id="'price' + index"
                                        class="border-gray-500 rounded-sm shadow-sm w-full"
                                        v-model="extra.price"
                                    >
                                        <option
                                            v-for="(
                                                price, index
                                            ) in extras_prices"
                                            :key="'cat-' + price"
                                            v-text="price"
                                            :value="index"
                                        ></option>
                                    </select>

                                    <InputError
                                        class="mt-2"
                                        :message="
                                            errors['extras.' + index + '.price']
                                        "
                                    />
                                </div>
                                <div
                                    class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4"
                                >
                                    <div>
                                        <select
                                            :id="'increased-time' + index"
                                            class="border-gray-500 rounded-sm shadow-sm w-full"
                                            v-model="extra.increased_time"
                                            @change="changedTime(index)"
                                        >
                                            <option
                                                v-for="(
                                                    time, index
                                                ) in extras_times"
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
                                    <div
                                        v-if="
                                            extras[index]?.increased_time ==
                                            'yes'
                                        "
                                    >
                                        <select
                                            :id="'time' + index"
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
                                                errors[
                                                    'extras.' + index + '.time'
                                                ]
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
                                <span>حفظ</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="lg:col-span-1">
                    <div class="mb-6">
                        <div class="text-xl mb-2">
                            أضف خدمتك وابدأ بتحقيق الأرباح
                        </div>
                        <div class="text-sm mb-2">
                            يتيح لك أنفينيتي ديزاين إمكانية تحقيق الأرباح عبر
                            إضافة خدمات تجيد تنفيذها وإتاحتها للبيع للعملاء
                            المهتمين. أدخل تفاصيل الخدمة بعناية ليقوم فريق
                            أنفينيتي ديزاين بمراجعتها ونشرها.
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="text-xl mb-2">نصائح لإضافة خدمة صحيحة</div>
                        <div class="mb-4">
                            <div class="text-base mb-2">عنوان الخدمة</div>
                            <div class="text-sm mb-2">
                                اختر عنوانًا مختصرًا وواضحًا يعكس ما ستقدمه
                                بالتحديد في خدمتك، ليتمكن المشترين من العثور
                                عليها عند البحث بكلمات ذات صلة بمجال الخدمة.
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-base mb-2">وصف الخدمة</div>
                            <div class="text-sm mb-2">
                                اكتب وصفًا مميزًا للخدمة بلغة سليمة خالية من
                                الأخطاء، تشرح خلاله ما سيحصل عليه العميل
                                بالتفصيل عند شراء الخدمة.
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-base mb-2">معرض الخدمة</div>
                            <div class="text-sm mb-2">
                                أضف صورة معبرة عن الخدمة بالإضافة إلى ثلاثة
                                نماذج حصرية على الأقل تعرّف المشتري من خلالها
                                على أسلوبك في العمل ومهاراتك.
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-base mb-2">سعر الخدمة</div>
                            <div class="text-sm mb-2">
                                احرص على تحديد سعر مناسب للخدمة بناء على حجم
                                العمل والجهد المبذول مع الأخذ بعين الاعتبار
                                عمولة الموقع، وحدد مدة تسليم مناسبة لإنجاز
                                الخدمة بإتقان.
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="text-base mb-2">
                                لماذا تُرفض الخدمة في أنفينيتي ديزاين؟
                            </div>
                            <div class="text-sm mb-2">
                                <ul
                                    class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400 pr-4"
                                >
                                    <li>
                                        عنوان طويل أو غير واضح أو يدمج أكثر من
                                        خدمة معًا
                                    </li>
                                    <li>
                                        تجاهل تحديد حجم العمل الذي سيحصل عليه
                                        المشتري في وصف الخدمة
                                    </li>
                                    <li>
                                        صور أو تصاميم ذات جودة منخفضة أو ليست من
                                        إعداد البائع
                                    </li>
                                    <li>
                                        إرفاق أقل من ثلاثة نماذج لمعرض أعمال
                                        الخدمة
                                    </li>
                                    <li>
                                        خدمات مخالفة وفقًا لشروط الاستخدام موقع
                                        أنفينيتي ديزاين
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
