<script setup>
import { Link } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import RateStars from "@/Components/RateStars.vue";
import GigImagesCarousel from "@/Components/GigImagesCarousel.vue";

// var authenticated = usePage().props.auth.authenticated;

defineProps({
    categories: Object,
    user: Object,
    avg: Number,
    count: Number,
});
</script>

<template>
    <NavBar :categories="categories" />

    <div class="mt-12 bg-gray-50">
        <div class="bg-white">
            <div
                class="max-w-screen-xl mx-auto py-16 flex items-center justify-center flex-col"
            >
                <div class="w-40 h-40 overflow-hidden mx-auto rounded-full">
                    <img
                        :src="'/storage/images/users/' + user.thumbnail"
                        class="w-full h-full"
                    />
                </div>
                <div class="font-bold mt-4 text-xl">
                    {{ user.name }}
                </div>
                <div class="font-bold mt-4 text-xl">
                    <Link
                        :href="route('profile')"
                        class="text-white bg-primary-light hover:bg-primary-dark duration-100 font-medium rounded-sm text-sm px-5 py-2.5"
                    >
                        تعديل الملف الشخصي
                    </Link>
                </div>
            </div>
        </div>
        <div
            class="p-6 grid grid-cols-1 lg:grid-cols-4 gap-4 max-w-screen-xl mx-auto"
        >
            <div class="col-span-3">
                <div class="bg-white mb-4">
                    <div
                        class="p-4 border-b border-b-gray-100 text-xl font-bold"
                    >
                        نبذة عني
                    </div>
                    <div class="p-4" v-text="user.description"></div>
                </div>
                <div class="bg-white mb-4">
                    <div
                        class="p-4 border-b border-b-gray-100 text-xl font-bold flex justify-between items-center"
                    >
                        <span>الخدمات المنشورة</span>
                        <span v-if="$page.props.auth.authenticated">
                            <a
                                :href="route('gigs.index')"
                                class="text-primary-light font-normal text-base"
                            >
                                كل الخدمات
                            </a>
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div v-if="user.gigs.length == 0">
                                لا توجد أية خدمات منشورة
                            </div>
                            <div
                                class="block relative bg-white shadow-md rounded-lg overflow-hidden"
                                v-for="gig in user.gigs"
                                :key="gig.id"
                            >
                                <GigImagesCarousel :gig="gig" />
                                <Link :href="route('gig', { slug: gig.slug })">
                                    <div
                                        class="block text-base py-1 px-4"
                                        v-text="gig.title"
                                    ></div>
                                </Link>
                                <RateStars
                                    :count="gig.r_count"
                                    :avg="gig.r_avg"
                                />
                                <div class="block py-1 px-4">
                                    <span> تبدأ من </span>
                                    <span
                                        v-text="gig.price_formated"
                                        class="text-base font-bold"
                                    ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-white">
                    <div
                        class="p-4 border-b border-b-gray-100 text-xl font-bold"
                    >
                        إحصائيات
                    </div>
                    <div class="p-4 grid grid-cols-2 py-4 px-2 gap-y-4">
                        <div class="block">التقييمات</div>
                        <div class="block -mx-3">
                            <RateStars
                                :avg="avg"
                                :count="count"
                                :showIt="true"
                            />
                        </div>
                        <div class="block">الخدمات المنشورة</div>
                        <div class="block">{{ user.gigs_count }}</div>
                        <div class="block">عدد العملاء</div>
                        <div class="block">{{ user.orders_count }}</div>
                        <div class="block">تاريخ التسجيل</div>
                        <div class="block">
                            {{ user.created_date }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
