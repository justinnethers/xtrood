<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import {Head, usePage} from '@inertiajs/vue3';
import FilamentRoll from "@/Components/FilamentRoll.vue";
import RollInformation from "@/Pages/Filament/partials/RollInformation.vue";
import {computed, ref} from "vue";
import {hasBeenUsed} from "@/utils.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";

const page = usePage();

const filterBarVisible = ref(true);

const brandFilter = ref("");
const filamentTypeFilter = ref("");
const colorFilter = ref("");

const filamentRolls = computed(() => {
    let rolls = page.props.filamentRolls;

    if(brandFilter.value) {
        rolls = rolls.filter(roll => roll.filament.brand.name === brandFilter.value);
    }

    if(filamentTypeFilter.value) {
        rolls = rolls.filter(roll => roll.filament.filament_type.name === filamentTypeFilter.value);
    }

    if(colorFilter.value) {
        rolls = rolls.filter(roll => roll.filament.color.name === colorFilter.value);
    }

    return rolls;
});

const brands = computed(() => {
    return Array.from(new Set(page.props.filamentRolls.map(roll => roll.filament.brand.name)));
});

const filamentTypes = computed(() => {
    return Array.from(new Set(page.props.filamentRolls.map(roll => roll.filament.filament_type.name)));
});

const colors = computed(() => {
    return Array.from(new Set(page.props.filamentRolls.map(roll => roll.filament.color.name)));
});

const fullRolls = computed(() => filamentRolls.value.filter(roll => !hasBeenUsed(roll)))
const partialRolls = computed(() => filamentRolls.value.filter(roll => {
    const weight = roll.weight - roll.usages.reduce((sum, item) => sum + item.weight, 0);
    if (Math.max(0, weight) == 0) {
        return false;
    }
    return hasBeenUsed(roll);
}));
const emptyRolls = computed(() => filamentRolls.value.filter(roll => {
    const weight = roll.weight - roll.usages.reduce((sum, item) => sum + item.weight, 0);
    if (Math.max(0, weight) > 0) {
        return false;
    }
    return true;
}));

const fullRollsGroupedByColorAndBrand = computed(() => {

    return fullRolls.value.reduce((acc, roll) => {
        if (!acc[roll?.filament.color.name+roll?.filament.brand.name]) {
            acc[roll?.filament.color.name+roll?.filament.brand.name] = [];
        }
        acc[roll?.filament.color.name+roll?.filament.brand.name].push(roll);
        return acc;
    }, {});
});

function clearFilters() {
    brandFilter.value = "";
    filamentTypeFilter.value = "";
    colorFilter.value = "";
}

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
            <div @click="filterBarVisible = !filterBarVisible" class="absolute block z-50 right-0 bg-blue-50 cursor-pointer p-2 rounded-br-none rounded-bl-none">|||</div>
            <transition name="slide-up-down">
            <div v-if="filterBarVisible" class="z-40 fixed bottom-0 right-0 left-0 bg-slate-800 grid grid-cols-2 md:flex gap-3 p-3 pt-1">
                <div class="w-full">
                    <InputLabel for="brand" value="Brand" />
                    <select class="w-full" id="brand" name="brand" v-model="brandFilter">
                        <option value="">All Brands</option>
                        <option v-for="brand in brands" :value="brand" :key="brand">{{ brand }}</option>
                    </select>
                </div>

                <div class="w-full">
                    <InputLabel for="type" value="Filament Type" />
                    <select class="w-full" id="type" name="type" v-model="filamentTypeFilter">
                        <option value="">All Types</option>
                        <option v-for="type in filamentTypes" :value="type" :key="type">{{ type }}</option>
                    </select>
                </div>

                <div class="w-full">
                    <InputLabel for="color" value="Color" />
                    <select class="w-full" id="color" name="color" v-model="colorFilter">
                        <option value="">All Colors</option>
                        <option v-for="color in colors" :value="color" :key="color">{{ color }}</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <PrimaryButton @click="clearFilters">Clear</PrimaryButton>
                </div>
            </div>
            </transition>
            <div class="p-8 bg-slate-700 rounded pb-28">
                <div v-if="partialRolls.length">
                    <h2 class="text-slate-50 mb-4">Partial Rolls <small class="font-light">(<span v-html="partialRolls.length"></span>)</small></h2>
                    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    <h2 class="text-slate-50 mb-4">Sealed Rolls <small class="font-light">(<span v-html="fullRolls.length"></span>)</small></h2>
                    <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <li
                            v-for="color in fullRollsGroupedByColorAndBrand"
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
                                    <RollInformation :multiple-rolls="!!color.length" :show-remaining="false" :roll="color[0]"/>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <br>
                </div>


                <div v-if="emptyRolls.length">
                    <h2 class="text-slate-50 mb-4">Empty Rolls <small class="font-light">(<span v-html="emptyRolls.length"></span>)</small></h2>
                    <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
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

<style scoped>
.slide-up-down-enter-active,
.slide-up-down-leave-active {
    transition: transform 0.5s;
}

.slide-up-down-enter-from,
.slide-up-down-leave-to {
    transform: translateY(100%);
}

.slide-up-down-enter-to,
.slide-up-down-leave-from {
    transform: translateY(0);
}
</style>
