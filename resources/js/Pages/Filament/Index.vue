<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FilamentRoll from "@/Components/FilamentRoll.vue";

const props = defineProps({
    filamentRolls: {
        type: Array,
    }
});

const fullRolls = props.filamentRolls.filter(roll => roll.usages.length == 0);
const partialRolls = props.filamentRolls.filter(roll => roll.usages.length > 0);
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-slate-50">My Filament</h1>
        </template>

        <div class="p-8 container mx-auto">
            <div class="p-8 bg-slate-700 rounded">
                <h2 class="text-slate-50 mb-2">Opened Rolls</h2>
                <ul v-if="partialRolls.length" class="grid grid-cols-3 gap-6">
                    <li v-for="roll in partialRolls" class="flex gap-6 bg-gray-300 p-6 rounded-md shadow-inner">
                        <FilamentRoll
                            :roll="roll"
                        />
                        <div class="flex flex-col w-full">
                            <div class="text-2xl">
                                <h3>{{ roll.filament.brand.name }}</h3>
                                <p>{{ roll.filament.color.name }} {{ roll.filament.filament_type.name }}</p>
                                <p>~<span class="font-bold">{{ roll.weight - roll.usages.reduce((sum, item) => sum + item.weight, 0) }}g</span> left</p>
<!--                                <pre>{{ roll.usages }}</pre>-->
                            </div>
                            <div class="flex-1"></div>
                            <div class="flex text-sm font-medium">
                                <div class="flex-1"></div>
                                <button class="bg-slate-800 text-white rounded px-4 py-2">Use Roll</button>
                            </div>
                        </div>
                    </li>
                </ul>

                <br>

                <h2 class="text-slate-50 mb-2">Sealed Rolls</h2>
                <ul v-if="fullRolls.length" class="grid grid-cols-4 gap-6">
                    <li v-for="roll in fullRolls" class="flex gap-6 bg-gray-300 p-6 rounded-md shadow-inner">
                        <FilamentRoll
                            :roll="roll"
                        />
                        <div class="flex flex-col w-full">
                            <div class="text-2xl">
                                <h3>{{ roll.filament.brand.name }}</h3>
                                <p>{{ roll.filament.color.name }} {{ roll.filament.filament_type.name }}</p>
                                <!--                            <pre>{{ roll.filament }}</pre>-->
                            </div>
                            <div class="flex-1"></div>
                            <div class="flex text-sm font-medium">
                                <div class="flex-1"></div>
                                <button class="bg-slate-800 text-white rounded px-4 py-2">Use Roll</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
