<script>
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import Alert from "@/Components/Alert.vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";

import { loadStripe } from "@stripe/stripe-js";
import { loadScript } from "@paypal/paypal-js";

export default {
    data() {
        return {
            form: useForm({
                content: null,
            }),
            user: usePage().props.auth.user,
            show: false,
            inPayment: true,

            amount: 5,

            error: null,
            stripe: null,
            elements: null,

            stripe_client_secret: null,
            intent_id: null,

            fomatter: new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            }),
        };
    },
    props: {
        categories: Object,
        chat: Object,
        recipient: Object,
        milestones: Object,
    },
    components: { Link, NavBar, Footer, Alert, Modal, InputLabel },
    methods: {
        send() {
            this.form.post(route("chats.message", { chat: this.chat.id }), {
                onSuccess: () => {
                    document.getElementById("chat").scrollTop = 10000;
                    this.form.content = null;
                },
            });
        },
        sendFile() {
            this.form.content = document.getElementById("file").files[0];
            this.form.post(route("chats.message", { chat: this.chat.id }), {
                onSuccess: () => {
                    document.getElementById("chat").scrollTop = 10000;
                    this.form.content = null;
                },
            });
        },
        createOffer() {
            axios({
                method: "post",
                responseType: "json",
                url: route("cart.create-offer", {
                    complete: "no",
                }),
                data: {
                    amount: this.amount,
                },
            })
                .then((response) => {
                    if (response.data.status) {
                        this.stripe_client_secret = response.data.paymentIntent;

                        this.setupStripe();
                        this.setupPaypal();

                        this.inPayment = false;
                    }
                })
                .catch((error) => {
                    this.error = error.response.data.message;
                });
        },
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
                document
                    .getElementById("payment-element")
                    .classList.remove("hidden");
                document
                    .getElementById("spinner-stripe")
                    .classList.add("hidden");
            });
        },
        async setupPaypal() {
            await loadScript({
                "client-id": usePage().props.options.paypal_client_id,
                "data-namespace": "paypal_sdk",
                "disable-funding": "card",
            })
                .then((paypal) => {
                    paypal
                        .Buttons({
                            createOrder: (data, actions) => {
                                return actions.order.create({
                                    purchase_units: [
                                        {
                                            amount: {
                                                value: this.amount,
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
                                        this.completeMilestone(
                                            "paypal",
                                            payment
                                        );
                                    });
                            },
                            onInit: () => {
                                document
                                    .getElementById("paypal-button-container")
                                    .classList.remove("hidden");
                                document
                                    .getElementById("paypal-button-container")
                                    .classList.add("flex");
                                document
                                    .getElementById("spinner-paypal")
                                    .classList.add("hidden");
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
                    this.completeMilestone("card", payment.paymentIntent);
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
        completeMilestone(type, data) {
            axios
                .post(
                    route("cart.create-offer", {
                        complete: "yes",
                    }),
                    {
                        data: data,
                        type: type,
                        amount: this.amount,
                        recipient: this.recipient.id,
                    }
                )
                .then((response) => {
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        completeInvoice(id) {
            router.post(route("cart.complete-offer", { invoice_id: id }));
        },
        read() {},
    },
    mounted() {
        router.post(route("messages.read", { chat: this.chat.id }));
    },
};
</script>
<template>
    <NavBar :categories="categories" />

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
                    <li>
                        <div class="flex items-center">
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
                            الرسائل
                        </div>
                    </li>
                </ol>
            </nav>

            <div
                class="my-6 w-full md:w-3/4 mx-auto bg-white p-2 md:p-6"
                v-if="chat.order"
            >
                <span class="mx-2">دردشة تحت طلبية</span>
                <span class="mx-2 font-bold">{{ chat.order.gig.title }}</span>
            </div>

            <div class="my-6">
                <div class="w-full md:w-3/4 mx-auto bg-white p-2 md:p-6">
                    <div class="max-h-96 overflow-auto" id="chat">
                        <article
                            v-if="chat.messages.length > 0"
                            v-for="message in chat.messages"
                            class="border-b border-b-gray-200 p-4 last-of-type:border-none"
                        >
                            <div class="flex items-center mb-4">
                                <img
                                    class="rounded-full w-11 h-11"
                                    :src="`/storage/images/users/${message.user.thumbnail}`"
                                />
                                <div class="font-medium dark:text-white mx-2">
                                    <p>
                                        <span
                                            v-if="message.user_id == user.id"
                                            v-text="user.username"
                                        ></span>
                                        <span
                                            v-else
                                            v-text="message.user.username"
                                        ></span>
                                        <time
                                            :datetime="
                                                message.formated_created_at
                                            "
                                            v-text="message.formated_created_at"
                                            class="block text-sm text-gray-500 dark:text-gray-400"
                                        ></time>
                                    </p>
                                </div>
                            </div>
                            <p
                                v-if="message.file == 'no'"
                                class="mb-2 text-gray-500 dark:text-gray-400"
                                v-text="message.content"
                            ></p>
                            <p
                                v-else
                                class="mb-2 text-gray-500 dark:text-gray-400"
                            >
                                <a :href="'/storage/files/' + message.content">
                                    {{ message.content }}
                                </a>
                            </p>
                        </article>
                        <article v-else class="block">
                            لا توجد رسائل بعد
                        </article>
                    </div>
                    <div class="mt-6">
                        <form @submit.prevent="send">
                            <div
                                class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
                            >
                                <div
                                    class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800"
                                >
                                    <label for="content" class="sr-only"
                                        >الرسالة</label
                                    >
                                    <textarea
                                        id="content"
                                        rows="4"
                                        class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                        required
                                        v-model="form.content"
                                    ></textarea>
                                </div>
                                <div
                                    class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600"
                                >
                                    <div>
                                        <button
                                            type="submit"
                                            class="mx-1 inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800"
                                        >
                                            ارسال
                                        </button>
                                        <label
                                            role="file"
                                            class="cursor-pointer mx-1 inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-green-700 rounded-lg focus:ring-4 focus:ring-green-200 dark:focus:ring-green-900 hover:bg-green-800"
                                        >
                                            <span>ملف</span>
                                            <input
                                                type="file"
                                                id="file"
                                                class="hidden"
                                                @change.prevent="sendFile"
                                            />
                                        </label>
                                    </div>
                                    <button
                                        type="button"
                                        @click.prevent="show = true"
                                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-orange-700 rounded-lg focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-900 hover:bg-orange-800"
                                    >
                                        إنشاء دفع
                                    </button>
                                    <!-- <div class="flex pl-0 space-x-1 sm:pl-2">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                                        >
                                            <svg
                                                aria-hidden="true"
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                    clip-rule="evenodd"
                                                ></path>
                                            </svg>
                                            <span class="sr-only"
                                                >Attach file</span
                                            >
                                        </button>
                                        <button
                                            type="button"
                                            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                                        >
                                            <svg
                                                aria-hidden="true"
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd"
                                                ></path>
                                            </svg>
                                            <span class="sr-only"
                                                >Set location</span
                                            >
                                        </button>
                                        <button
                                            type="button"
                                            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                                        >
                                            <svg
                                                aria-hidden="true"
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clip-rule="evenodd"
                                                ></path>
                                            </svg>
                                            <span class="sr-only"
                                                >Upload image</span
                                            >
                                        </button>
                                    </div> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div
                    class="w-full md:w-3/4 mx-auto bg-white py-2 md:py-6 mt-10"
                    v-if="milestones.length > 0"
                >
                    <div
                        class="text-xl font-bold text-black bg-white mb-4 px-4"
                    >
                        معاملاتي المالية مع {{ recipient.name }}
                    </div>
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-l-lg">
                                    الحالة
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    طريقة الدفع
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-r-lg">
                                    السعر
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-r-lg">
                                    التاريخ
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-r-lg">
                                    خيارات
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white dark:bg-gray-800"
                                v-for="invoice in milestones"
                            >
                                <td
                                    class="px-6 py-4"
                                    v-text="invoice.tr_status"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="invoice.method"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="fomatter.format(invoice.amount)"
                                ></td>
                                <td
                                    class="px-6 py-4"
                                    v-text="invoice.created_date"
                                ></td>
                                <td class="px-6 py-4">
                                    <button
                                        v-if="invoice.status == 'pending'"
                                        @click="completeInvoice(invoice.id)"
                                        class="px-4 py-2 text-sm text-white bg-green-500 rounded-md"
                                    >
                                        إرسال
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal :show="show" @close="show = false">
            <div
                v-if="error"
                class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-200 dark:text-red-800"
                role="alert"
                v-text="error"
            ></div>
            <div class="block mb-4" v-show="inPayment">
                <div class="block my-2">
                    <InputLabel for="amount" value="سعر العرض" />

                    <input
                        type="number"
                        step="0.01"
                        id="amount"
                        class="border-gray-500 rounded-sm shadow-sm w-full"
                        v-model="amount"
                    />
                </div>
                <div class="block my-2">
                    <button
                        @click.prevent="createOffer"
                        type="button"
                        class="text-white bg-primary-light hover:bg-primary-dark duration-100 font-bold rounded-sm text-base px-5 py-2.5"
                    >
                        تأكيد
                    </button>
                </div>
            </div>
            <div class="block mb-4" v-show="!inPayment">
                <div class="block my-2">
                    <button
                        @click.prevent=""
                        type="button"
                        class="text-white bg-red-500 hover:bg-red-400 duration-100 font-bold rounded-sm text-sm py-2 px-4"
                    >
                        عودة
                    </button>
                </div>
            </div>
            <form
                @submit.prevent="handleStripePayment()"
                class="mb-4"
                v-show="!inPayment"
            >
                <div
                    class="my-6 flex justify-center items-center"
                    id="spinner-stripe"
                >
                    <svg
                        aria-hidden="true"
                        role="status"
                        class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="#1C64F2"
                        />
                    </svg>
                </div>
                <div id="payment-element" class="hidden"></div>
                <button
                    id="btnStripeSubmit"
                    type="submit"
                    class="hidden text-white bg-primary-light hover:bg-primary-dark duration-100 font-bold rounded-sm text-base px-5 py-2.5 mt-4"
                >
                    متابعة الدفع
                </button>
            </form>
            <div class="block mx-auto px-5 py-4" v-show="!inPayment">
                <div class="relative rounded-md border-t border-t-gray-600">
                    <h2
                        class="absolute flex top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                    >
                        <span class="bg-white px-2 text-xl font-bold">أو</span>
                    </h2>
                </div>
            </div>
            <div class="block mx-auto px-5 py-4" v-show="!inPayment">
                <div
                    class="my-6 flex justify-center items-center"
                    id="spinner-paypal"
                >
                    <svg
                        aria-hidden="true"
                        role="status"
                        class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="#1C64F2"
                        />
                    </svg>
                </div>
                <div
                    id="paypal-button-container"
                    class="hidden justify-center items-center"
                ></div>
            </div>
        </Modal>
    </div>

    <Footer />
</template>
