<script setup>
import { Link } from "@inertiajs/vue3";
import { Splide, SplideSlide } from "@splidejs/vue-splide";

import "@splidejs/vue-splide/css";

defineProps({
    gig: Object,
    showUser: {
        type: Boolean,
        default: true,
    },
    height: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div :id="'default-carousel-' + gig.id" class="relative w-full">
        <Splide :aria-label="'slider-' + gig.id">
            <SplideSlide
                v-for="thumbnail in gig.thumbnails"
                :key="'image-thumbnail-' + thumbnail"
            >
                <Link :href="route('gig', { slug: gig.slug })">
                    <img
                        :src="'/storage/images/gigs/' + thumbnail"
                        :alt="thumbnail"
                        class="w-full"
                        :class="{ 'h-auth': height, 'h-48': !height }"
                    />
                </Link>
            </SplideSlide>
        </Splide>
        <div
            class="absolute bottom-1 left-1 z-10 w-10 h-10 rounded-full overflow-hidden"
            v-if="showUser"
        >
            <Link :href="route('user', { username: gig.user.username })">
                <img
                    :src="'/storage/images/users/' + gig.user.thumbnail"
                    class="w-full"
                />
            </Link>
        </div>
    </div>
</template>

<style lang="sass">
.splide__slide
    display: none
    &.is-active
        display: block
</style>
