<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        rate: Object,
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
<td class='px-6 py-4'>{{rate.id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.name')}}</th>
<td class='px-6 py-4'>{{rate.name}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.count')}}</th>
<td class='px-6 py-4'>{{rate.count}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.review_id')}}</th>
<td class='px-6 py-4'>{{rate.review_id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.gig_id')}}</th>
<td class='px-6 py-4'>{{rate.gig_id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.created_at')}}</th>
<td class='px-6 py-4'>{{rate.created_at}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.updated_at')}}</th>
<td class='px-6 py-4'>{{rate.updated_at}}</td>
</tr>

                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
