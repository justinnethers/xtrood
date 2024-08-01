<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import {Head, usePage} from '@inertiajs/vue3';
import FilamentRoll from "@/Components/FilamentRoll.vue";
import RollInformation from "@/Pages/Filament/partials/RollInformation.vue";
import {computed} from "vue";

const page = usePage();

const filamentRolls = computed(() => page.props.filamentRolls);

const fullRolls = computed(() => filamentRolls.value.filter(roll => roll.usages.length == 0));
const partialRolls = computed(() => filamentRolls.value.filter(roll => {
    const weight = roll.weight - roll.usages.reduce((sum, item) => sum + item.weight, 0);
    if (Math.max(0, weight) == 0) {
        return false;
    }
    return roll.usages.length > 0;
}));
const emptyRolls = computed(() => filamentRolls.value.filter(roll => {
    const weight = roll.weight - roll.usages.reduce((sum, item) => sum + item.weight, 0);
    if (Math.max(0, weight) > 0) {
        return false;
    }
    return true;
}));

const fullRollsGroupedByColor = computed(() => {
    return fullRolls.value.reduce((acc, roll) => {
        if (!acc[roll?.filament.color.name]) {
            acc[roll?.filament.color.name] = [];
        }
        acc[roll?.filament.color.name].push(roll);
        return acc;
    }, {});
});

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h1 class="text-slate-50">Filament Inventory</h1>
                <NavLink :href="route('filament.create')">Add Roll</NavLink>
            </div>
        </template>

        <div class="">
            <div class="p-8 bg-slate-700 rounded">
                <div v-if="partialRolls.length">
                    <h2 class="text-slate-50 mb-4">Partial Rolls</h2>
                    <ul class="grid grid-cols-3 gap-6">
                        <li
                            v-for="roll in partialRolls"
                            class="flex gap-6 bg-gray-300 p-6 rounded-md shadow-inner hover:shadow-2xl"
                        >
                            <FilamentRoll
                                :roll="roll"
                            />
                            <RollInformation :roll="roll"/>
                        </li>
                    </ul>

                    <br>
                </div>

                <div v-if="fullRolls.length">
                    <h2 class="text-slate-50 mb-4">Sealed Rolls</h2>
                    <ul class="grid grid-cols-4 gap-6">
                        <li
                            v-for="color in fullRollsGroupedByColor"
                            class="grid grid-cols-1 px-3 pb-3 bg-gray-300 rounded-md shadow-inner"
                        >
                            <div v-if="color.length == 1">
                                <div v-for="roll in color">
                                    <FilamentRoll
                                        :roll="roll"
                                        :rotate="true"
                                        class="pt-3 pb-1"
                                    />
                                    <RollInformation :show-remaining="false" :roll="roll"/>
                                </div>
                            </div>
                            <div v-else>
                                <div class="relative">
                                <span
                                    class="absolute right-0 mr-3 bg-gradient-to-br from-green-600 to-green-800 p-2.5 text-blue-50 text-2xl font-bold rounded-b shadow-xl">{{
                                        color.length
                                    }}</span>
                                    <FilamentRoll
                                        :roll="color[0]"
                                        :rotate="true"
                                        class="pt-3 pb-1"
                                    />
                                    <RollInformation :show-remaining="false" :roll="color[0]"/>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <br>
                </div>


                <div v-if="emptyRolls.length">
                    <h2 class="text-slate-50 mb-4">Empty Rolls</h2>
                    <ul class="grid grid-cols-5 gap-6">
                        <li
                            v-for="roll in emptyRolls"
                            class="grid grid-cols-1 px-3 pb-3 bg-gray-300 rounded-md shadow-inner hover:shadow-2xl"
                        >
                            <FilamentRoll
                                :roll="roll"
                                :rotate="true"
                                class="pt-3 pb-1"
                            />
                            <RollInformation :show-remaining="false" :roll="roll" :is-empty="true" />
                        </li>
                    </ul>
                </div>

                <div v-if="!emptyRolls.length && !fullRolls.length && !partialRolls.length">
                    <NavLink :href="route('filament.create')">Add Roll</NavLink>
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>
