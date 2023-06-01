<script>
import { Link } from "@inertiajs/vue3";
export default {
    props: {
        model: Object,
    },
    components: {
        Link,
    },
};
</script>
<template>
    <div class="pagination my-5">
        <nav aria-label="Page navigation example">
            <ul
                class="flex justify-center items-center -space-x-px overflow-x-auto mt-4 h-11"
            >
                <li v-for="(link, id) in model.links" :key="id">
                    <Link
                        v-if="!link.active && link.url"
                        :href="link.url"
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-pointer"
                    >
                        {{ link.label }}
                    </Link>
                    <Link
                        v-else-if="!link.active"
                        href="#"
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-pointer"
                    >
                        {{ link.label }}
                    </Link>
                    <a
                        v-else
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-default"
                    >
                        {{ link.label }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
