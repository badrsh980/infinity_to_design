<script>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    props: {
        notification: Object,
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
<td class='px-6 py-4'>{{notification.id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.type')}}</th>
<td class='px-6 py-4'>{{notification.type}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.notifiable_type')}}</th>
<td class='px-6 py-4'>{{notification.notifiable_type}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.notifiable_id')}}</th>
<td class='px-6 py-4'>{{notification.notifiable_id}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.data')}}</th>
<td class='px-6 py-4'>{{notification.data}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.read_at')}}</th>
<td class='px-6 py-4'>{{notification.read_at}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.created_at')}}</th>
<td class='px-6 py-4'>{{notification.created_at}}</td>
</tr>
<tr>
<th scope='col' class='px-6 py-3'>{{$t('message.updated_at')}}</th>
<td class='px-6 py-4'>{{notification.updated_at}}</td>
</tr>

                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
