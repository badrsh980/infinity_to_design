import "../css/app.css";

import { initFlowbite } from "flowbite";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import FontAwesomeIcon from "@/fontawesome";
import { createI18n } from "vue-i18n";
import "./bootstrap";

import messages from "./lang/ar";

const clickOutside = {
    beforeMount: (el, binding) => {
        el.clickOutsideEvent = (event) => {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                binding.value();
            }
        };
        document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: (el) => {
        document.removeEventListener("click", el.clickOutsideEvent);
    },
};

const i18n = createI18n({
    locale: "ar", // set locale
    fallbackLocale: "ar", // set fallback locale
    messages,
});

createInertiaApp({
    title: (title) => "إنفينيتي ديزاين",
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        initFlowbite();
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18n)
            .component("font-awesome-icon", FontAwesomeIcon)
            .directive("click-outside", clickOutside);

        return app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
