<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h1 class="text-slate-50">Printers</h1>
                <NavLink :href="route('user-printers.create')">Add Printer</NavLink>
            </div>
        </template>

        <div class="p-8 bg-slate-700 rounded">

            <div v-if="userPrinters.length === 0" class="text-slate-300">
                You haven't added any printers to your collection yet.
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="userPrinter in userPrinters" :key="userPrinter.id" class="bg-slate-600 p-6 rounded-lg shadow">
                    <h3 class="text-xl text-slate-50 mb-2">{{ userPrinter.nickname || userPrinter.printer.name }}</h3>
                    <p class="text-slate-300">{{ userPrinter.printer.brand }} {{ userPrinter.printer.model }}</p>
                    <p class="text-slate-300">Bed Size: {{ userPrinter.printer.bed_size_x }}x{{ userPrinter.printer.bed_size_y }}x{{ userPrinter.printer.bed_size_z }}mm</p>
                    <p v-if="userPrinter.purchase_date" class="text-slate-300">Purchased: {{ userPrinter.purchase_date }}</p>
                    <div class="mt-4 flex justify-between">
                        <Link :href="route('user-printers.show', userPrinter.id)" class="text-blue-400 hover:underline">View Details</Link>
                        <Link :href="route('user-printers.edit', userPrinter.id)" class="text-yellow-400 hover:underline">Edit</Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from "@/Components/NavLink.vue";

defineProps({
    userPrinters: Array,
});
</script>
