<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        invoice: Object,
    },
    components: {
        AdminLayout,
        Footer,
        Link,
    }
};
</script>

<template>
    <AdminLayout>
        <div class="mt-12 p-6 bg-gray-50">
            <div class="my-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                    >
                        <tr>
<th scope='col' class='px-6 py-3'>{{$t('message.id')}}</th>
<td class='px-6 py-4'>{{invoice.id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.type')}}</th>
<td class='px-6 py-4'>{{invoice.type}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.status')}}</th>
<td class='px-6 py-4'>{{invoice.status}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.payment_method')}}</th>
<td class='px-6 py-4'>{{invoice.payment_method}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.details')}}</th>
<td class='px-6 py-4'>{{invoice.details}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.amount')}}</th>
<td class='px-6 py-4'>{{invoice.amount}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.order_id')}}</th>
<td class='px-6 py-4'>{{invoice.order_id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.user_id')}}</th>
<td class='px-6 py-4'>{{invoice.user_id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.created_at')}}</th>
<td class='px-6 py-4'>{{invoice.created_at}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.updated_at')}}</th>
<td class='px-6 py-4'>{{invoice.updated_at}}</td>
</tr>

                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
