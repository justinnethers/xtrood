<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import TheFilamentRoll from "@/Components/TheFilamentRoll.vue";

const page = usePage();

const roll = computed(() => page.props.filamentRoll);
const remainingWeight = computed(() => roll.value.weight - roll.value.usages.reduce((sum, item) => sum + item.weight, 0));
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h1 class="text-slate-50">
                    {{ roll.filament.brand.name }}
                    <span class="text-2xl">
                    {{ roll.filament.color.name }} {{ roll.filament.filament_type.name }}
                </span>
                </h1>
                <div class="flex-1"></div>
                <TheFilamentRoll :roll="roll" :rotate="true"/>
            </div>
        </template>

        <div class="text-slate-50">
            <div class="p-8 bg-slate-700 rounded relative shadow-inner">
                <div>
                    <div v-if="roll.price"
                         class="absolute right-0 top-0 bg-green-500 p-6 py-8 text-4xl font-bold rounded-b mr-12 shadow-2xl">
                        ${{ roll.price }}
                    </div>
                    <div>
                        <h3>~{{ remainingWeight }}g remaining</h3>
                    </div>
                    <br>
                    <div class="">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-2xl">Prints</h1>
                            </div>
<!--                            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">-->
<!--                                <button type="button"-->
<!--                                        class="button">-->
<!--                                    Use Roll-->
<!--                                </button>-->
<!--                            </div>-->
                        </div>
                        <div class="mt-4 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    Amount Used
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Date Printed
                                                </th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="usage in roll.usages" :key="usage.id">
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ usage.weight }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ usage.created_at }}
                                                </td>
                                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                                    >Edit<span class="sr-only">, {{ usage.id }}</span></a
                                                    >
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
