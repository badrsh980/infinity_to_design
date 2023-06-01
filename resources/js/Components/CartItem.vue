<script>
export default {
    emits: ["deleteItem", "prices"],
    data() {
        return {
            total: 0,
            extras_prices: {},
            formatter: new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            }),
        };
    },
    props: {
        item: Object,
    },
    methods: {
        addExtra(extra) {
            if (extra.id in this.extras_prices) {
                delete this.extras_prices[extra.id].price;
                delete this.extras_prices[extra.id];
            } else {
                this.extras_prices[extra.id] = {
                    price: parseFloat(extra.price),
                };
            }

            this.priceFormated();
            this.updateCartItem();
        },
        checked(item, extra_id) {
            var check = false;

            item.extras.forEach((value) => {
                if (value.id == extra_id) check = true;
            });

            return check;
        },
        priceFormated() {
            var total = 0;

            total += parseFloat(this.item.gig.price);

            for (const [id, extra] of Object.entries(this.extras_prices)) {
                total += parseFloat(extra.price);
            }

            this.total = this.formatter.format(total);

            this.$emit("prices", {
                item_id: this.item.id,
                price: parseFloat(total),
            });
        },
        makeExtrasPrices() {
            this.item.extras.forEach((value) => {
                this.extras_prices[value.id] = {
                    price: parseFloat(value.price),
                };
            });
        },
        updateCartItem() {
            axios.post(
                route("api.update-items-cart", { item_id: this.item.id }),
                {
                    extras: this.extras_prices,
                }
            );
        },
    },
    mounted() {
        this.makeExtrasPrices();
        this.priceFormated();
    },
};
</script>

<template>
    <th class="p-4">
        <div class="flex">
            <div>
                <img
                    class="w-36 mx-2"
                    :src="'/storage/images/gigs/' + item.gig.thumbnails[0]"
                    alt=""
                />
            </div>
            <div>
                <div
                    class="text-base font-normal"
                    v-text="item.gig.title"
                ></div>
                <div
                    class="text-sm font-normal"
                    v-text="item.gig.user.username"
                ></div>
                <div class="my-2">
                    <div
                        class="flex items-center mb-1"
                        v-for="extra in item.gig.extras"
                    >
                        <input
                            :id="'default-checkbox' + extra.id"
                            type="checkbox"
                            :checked="checked(item, extra.id)"
                            @click="addExtra(extra)"
                            :value="{
                                item_id: item.id,
                                extra_id: extra.id,
                                extra_price: extra.price,
                            }"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        />
                        <label
                            :for="'default-checkbox' + extra.id"
                            class="mr-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >
                            <span v-text="extra.title"></span>
                            (<span
                                v-text="this.formatter.format(extra.price)"
                            ></span
                            >)
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </th>
    <td class="p-4 text-xl" v-text="total"></td>
    <td class="p-4">
        <button
            type="button"
            @click="$emit('deleteItem', item.id)"
            class="text-white bg-red-500 hover:bg-primary-dark duration-100 font-medium rounded-lg text-sm px-2 py-1"
        >
            حذف
        </button>
    </td>
</template>
