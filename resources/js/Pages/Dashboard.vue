<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    filamentRolls: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div>
                        <ul v-if="filamentRolls.length" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <li
                                v-for="roll in filamentRolls"
                                class="bg-white rounded p-2"
                                :style="{ backgroundColor: roll.filament.color.name }"
                            >
                                <h1 class="bg-gray-900 text-white p-1 px-2 rounded font-bold">
                                    {{ roll.filament.brand.name }} {{ roll.filament.color.name }} {{ roll.filament.filament_type.name }}
                                </h1>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
