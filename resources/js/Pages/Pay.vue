<script>
import { Link, usePage } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import { loadStripe } from "@stripe/stripe-js";
import { loadScript } from "@paypal/paypal-js";

export default {
    data() {
        return {
            formatter: new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            }),
            error: null,
            stripe: null,
            elements: null,
        };
    },
    components: {
        Link,
        NavBar,
        Footer,
    },
    props: {
        cart: Object,
        categories: Object,
        total: Number,
        fees: Number,
        all: Number,
        stripe_client_secret: String,
        intent_id: String,
    },
    methods: {
        tab(id) {
            // document.querySelectorAll(".tab").forEach((e) => {
            //     e.classList.add("hidden");
            // });
            // const t = document.getElementById(id).classList.remove("hidden");
        },
    },
    async mounted() {
        this.setupStripe();
        await this.setupPaypal();
    },

    methods: {
        async setupStripe() {
            this.stripe = await loadStripe(
                usePage().props.options.stripe_public_key
            );

            this.elements = this.stripe.elements({
                clientSecret: this.stripe_client_secret,
                locale: usePage().props.options.language,
            });

            const paymentElementOptions = {
                layout: "tabs",
            };

            const paymentElement = this.elements.create(
                "payment",
                paymentElementOptions
            );
            paymentElement.mount("#payment-element");

            paymentElement.on("ready", function (event) {
                document
                    .getElementById("btnStripeSubmit")
                    .classList.remove("hidden");
            });
        },
        async handleStripePayment() {
            const { error } = await this.stripe
                .confirmPayment({
                    elements: this.elements,
                    redirect: "if_required",
                    confirmParams: {
                        return_url: "http://google.com",
                        receipt_email: usePage().props.auth.user.email,
                    },
                })
                .then((payment) => {
                    axios
                        .post(
                            route("api.confirm-payment", {
                                type: "card",
                            }),
                            {
                                data: payment.paymentIntent,
                            }
                        )
                        .then((response) => {
                            window.location = route("purchases");
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                });

            if (
                error.type === "card_error" ||
                error.type === "validation_error"
            ) {
                this.error = error.message;
            } else {
                this.error = "خطأ غير متوقع، حاول مجددا";
            }
        },
        async setupPaypal() {
            await loadScript({
                "client-id": usePage().props.options.paypal_client_id,
                "data-namespace": "paypal_sdk",
            })
                .then((paypal) => {
                    paypal
                        .Buttons({
                            createOrder: (data, actions) => {
                                return actions.order.create({
                                    purchase_units: [
                                        {
                                            amount: {
                                                value: this.all,
                                                currency_code: "USD",
                                            },
                                        },
                                    ],
                                });
                            },
                            onApprove: (data, actions) => {
                                return actions.order
                                    .capture()
                                    .then(function (payment) {
                                        axios
                                            .post(
                                                route("api.confirm-payment", {
                                                    type: "card",
                                                }),
                                                {
                                                    data: payment,
                                                }
                                            )
                                            .then((response) => {
                                                window.location =
                                                    route("purchases");
                                            })
                                            .catch((error) => {
                                                console.log(error);
                                            });
                                    });
                            },
                        })
                        .render("#paypal-button-container");
                })
                .catch((err) => {
                    console.error(
                        "failed to load the PayPal JS SDK script",
                        err
                    );
                });
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
                            :href="route('cart')"
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
                            سلة المشتريات
                        </a>
                    </li>
                </ol>
            </nav>
            <div class="my-4 text-2xl">إتمام عملية الدفع</div>

            <div class="my-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <div class="">
                            <ul
                                class="flex flex-wrap -mb-px text-sm font-medium text-center"
                                id="myTab"
                                data-tabs-toggle="#paymentMethods"
                                role="tablist"
                            >
                                <li class="" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg"
                                        id="credit-card-tab"
                                        data-tabs-target="#credit-card"
                                        type="button"
                                        role="tab"
                                        aria-controls="credit-card"
                                        aria-selected="false"
                                    >
                                        <font-awesome-icon icon="credit-card" />
                                        <span class="text-base mx-2"
                                            >البطاقة البنكية</span
                                        >
                                    </button>
                                </li>
                                <li class="" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg"
                                        id="paypal-tab"
                                        data-tabs-target="#paypal"
                                        type="button"
                                        role="tab"
                                        aria-controls="paypal"
                                        aria-selected="false"
                                    >
                                        <font-awesome-icon
                                            :icon="['fab', 'paypal']"
                                        />
                                        <span class="text-base mx-2"
                                            >بايبال</span
                                        >
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div id="paymentMethods">
                            <div
                                class="tab p-4 rounded-lg bg-white dark:bg-gray-800"
                                id="credit-card"
                                role="tabpanel"
                                aria-labelledby="credit-card-tab"
                            >
                                <form @submit.prevent="handleStripePayment()">
                                    <div
                                        v-if="error"
                                        class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-200 dark:text-red-800"
                                        role="alert"
                                        v-text="error"
                                    ></div>
                                    <div id="payment-element"></div>
                                    <button
                                        id="btnStripeSubmit"
                                        type="submit"
                                        class="hidden text-white bg-primary-light hover:bg-primary-dark duration-100 font-bold rounded-sm text-base px-5 py-2.5 mt-4"
                                    >
                                        متابعة الدفع
                                    </button>
                                </form>
                            </div>
                            <div
                                class="tab hidden p-4 rounded-lg bg-white dark:bg-gray-800"
                                id="paypal"
                                role="tabpanel"
                                aria-labelledby="paypal-tab"
                            >
                                <div
                                    id="paypal-button-container"
                                    class="flex justify-center items-center"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <div class="block bg-white">
                        <div class="p-4 border-b-1 border-gray-300">
                            تفاصيل الفاتورة
                        </div>
                        <div class="p-4">
                            <div class="my-6 w-64 text-xl">
                                <div
                                    class="flex justify-between items-center my-2"
                                >
                                    <div>الإجمالي</div>
                                    <div v-text="formatter.format(total)"></div>
                                </div>
                                <div
                                    class="flex justify-between items-center my-2"
                                >
                                    <div>الرسوم</div>
                                    <div v-text="formatter.format(fees)"></div>
                                </div>
                                <div
                                    class="flex justify-between items-center my-2 font-bold"
                                >
                                    <div>المجموع</div>
                                    <div v-text="formatter.format(all)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>

<style>
[aria-selected="true"] {
    background: #fff;
}
.tab.hidden {
    background: #f8f8f8;
}
</style>
