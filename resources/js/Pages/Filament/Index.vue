<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import {Head, usePage} from '@inertiajs/vue3';
import RollInformation from "@/Pages/Filament/partials/RollInformation.vue";
import {computed, nextTick, onBeforeUnmount, onMounted, reactive, ref} from "vue";
import {hasBeenUsed} from "@/utils.js";
import InputLabel from "@/Components/InputLabel.vue";
import TheFilamentRoll from "@/Components/TheFilamentRoll.vue";

const page = usePage();

const filterBarVisible = ref(false);
const filterBarHeight = ref(0);
const filterBarRef = ref(null);
const emptyRollsVisible = ref(false);
const partialRollsVisible = ref(true);
const sealedRollsVisible = ref(true);
const isRollVisible = ref({
    empty: true,
    sealed: true,
    partial: true,
});

const brandFilter = ref("");
const filamentTypeFilter = ref("");
const colorFilter = ref("");

const filamentRolls = computed(() => {
    let rolls = page.props.filamentRolls;

    if(brandFilter.value) {
        rolls = rolls.filter(roll => {
            return roll.filament.brand.name === brandFilter.value
        });
    }

    if(filamentTypeFilter.value) {
        rolls = rolls.filter(roll => {
            return roll.filament.filament_type.name === filamentTypeFilter.value
        });
    }

    if(colorFilter.value) {
        rolls = rolls.filter(roll => {
            return roll.filament.color.name === colorFilter.value
        });
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

const toggleRollVisibility = (type) => {
    if (isRollVisible.value[type]) {
        isRollVisible.value[type] = false;
    } else {
        isRollVisible.value[type] = true;
        nextTick(() => {
            filamentRolls.value.filter(roll => {
                return hasBeenUsed(roll) === isRollVisible.value[type];
            }).forEach((roll, index) => {
                setTimeout(() => {
                    roll.visible = true;
                }, index * 50);
            });
        });

    }
};

const toggleEmptyRolls = () => {
    if (emptyRollsVisible.value) {
        emptyRollsVisible.value = false;
    } else {
        emptyRollsVisible.value = true;
        nextTick(() => {
            emptyRolls.value.forEach((roll, index) => {
                setTimeout(() => {
                    roll.visible = true;
                }, index * 50);
            });
        });
    }
};

const toggleFilterBar = () => {
    filterBarVisible.value = !filterBarVisible.value;
    nextTick(() => {
        updateFilterBarHeight();
    });
};

const updateFilterBarHeight = () => {
    if (filterBarVisible.value && filterBarRef.value) {
        filterBarHeight.value = filterBarRef.value.offsetHeight;
    } else {
        filterBarHeight.value = 0;
    }
};

const clearFilters = () => {
    brandFilter.value = '';
    filamentTypeFilter.value = '';
    colorFilter.value = '';
};

onMounted(() => {
    updateFilterBarHeight();
    window.addEventListener('resize', updateFilterBarHeight);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', updateFilterBarHeight);
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
            <div class="relative">
                <div
                    @click="toggleFilterBar"
                    class="fixed z-50 flex items-center justify-center bg-slate-800 text-white font-bold cursor-pointer text-lg p-2 px-6 rounded-tl-md transition-all duration-500 right-0"
                    :style="{
                        bottom: filterBarVisible ? `${filterBarHeight}px` : '0px'
                      }"
                >
                    Filters
                </div>
                <transition name="slide-up-down">
                    <div
                        v-if="filterBarVisible"
                        class="z-40 fixed bottom-0 right-0 left-0 bg-slate-800 grid grid-cols-2 md:flex gap-1 md:gap-3 p-1.5 md:p-3"
                        ref="filterBarRef"
                    >
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
                            <button class="p-2 bg-slate-100 text-slate-950 w-full" @click="clearFilters">Clear</button>
                        </div>
                    </div>
                </transition>
            </div>

            <div
                class="p-4 md:p-8 bg-slate-700 rounded transition-all duration-500"
                :style="{
                    paddingBottom: filterBarVisible ? `calc(${filterBarHeight}px + 2rem)` : '2rem'
                }"
            >
                <div v-if="partialRolls.length">
                    <div class="flex justify-between items-center">
                        <h2 class="text-slate-50 mb-4">Partial Rolls <small class="font-light">(<span v-html="partialRolls.length"></span>)</small></h2>

                        <button
                            class="p-2 bg-transparent text-slate-50 border border-slate-500"
                            @click="toggleRollVisibility('partial')"
                        >{{ isRollVisible['partial'] ? 'Hide Partial Rolls' : 'Show Partial Rolls'}}</button>
                    </div>
                    <transition-group name="empty-rolls" tag="ul" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                        <li
                            v-for="roll in isRollVisible['partial'] ? partialRolls : []"
                            class="flex gap-4 md:gap-6 bg-slate-600 p-6 rounded-md shadow-inner hover:shadow-2xl empty-roll-item"
                        >
                            <TheFilamentRoll
                                :roll="roll"
                            />
                            <RollInformation text-size="text-3xl md:text-2xl" :roll="roll"/>
                        </li>
                    </transition-group>

                    <br>
                </div>

                <div v-if="fullRolls.length">
                    <div class="flex justify-between items-center">
                        <h2 class="text-slate-50 mb-4">Sealed Rolls <small class="font-light">(<span v-html="fullRolls.length"></span>)</small></h2>
                        <button
                            class="p-2 bg-transparent text-slate-50 border border-slate-500"
                            @click="toggleRollVisibility('sealed')"
                        >{{ isRollVisible['sealed'] ? 'Hide Sealed Rolls' : 'Show Sealed Rolls'}}</button>
                    </div>
                    <transition-group name="empty-rolls" tag="ul" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                        <li
                            v-for="color in isRollVisible['sealed'] ? fullRollsGroupedByColorAndBrand : []"
                            class="grid grid-cols-1 px-3 pb-3 bg-slate-600 rounded-md shadow-inner hover:shadow-2xl empty-roll-item"
                        >
                            <div v-if="color.length == 1">
                                <div v-for="roll in color">
                                    <TheFilamentRoll
                                        :roll="roll"
                                        :rotate="true"
                                        class="pt-3 pb-1"
                                    />
                                    <RollInformation text-size="text-xl md:text-2xl" :show-remaining="false" :roll="roll"/>
                                </div>
                            </div>
                            <div v-else>
                                <div class="relative">
                                    <span
                                        class="absolute z-30 right-0 mr-3 bg-gradient-to-br from-green-600 to-green-800 p-2.5 text-blue-50 text-2xl font-bold rounded-b shadow-xl">{{
                                        color.length
                                    }}</span>
                                    <TheFilamentRoll
                                        :roll="color[0]"
                                        :rotate="true"
                                        class="pt-3 pb-1"
                                    />
                                    <RollInformation text-size="text-xl md:text-2xl" :multiple-rolls="!!color.length" :show-remaining="false" :roll="color[0]"/>
                                </div>
                            </div>
                        </li>
                    </transition-group>

                    <br>
                </div>


                <div v-if="emptyRolls.length">
                    <div class="flex justify-between items-center">
                        <h2 class="text-slate-50 mb-4">Empty Rolls <small class="font-light">(<span v-html="emptyRolls.length"></span>)</small></h2>

                        <button
                            class="p-2 bg-transparent text-slate-50 border border-slate-500"
                            @click="toggleRollVisibility('empty')"
                        >{{ isRollVisible['empty'] ? 'Hide Empty Rolls' : 'Show Empty Rolls'}}</button>

                    </div>
                    <transition-group name="empty-rolls" tag="ul" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                        <li
                            v-for="roll in isRollVisible['empty'] ? emptyRolls : []"
                            :key="roll.id"
                            class="grid grid-cols-1 px-3 pb-3 bg-slate-600 rounded-md shadow-inner hover:shadow-2xl empty-roll-item"
                        >
                            <TheFilamentRoll
                                :roll="roll"
                                :rotate="true"
                                class="pt-3 pb-1"
                            />
                            <RollInformation text-size="text-xl md:text-2xl" :show-remaining="false" :roll="roll" :is-empty="true" />
                        </li>
                    </transition-group>
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

.empty-rolls-enter-active,
.empty-rolls-leave-active {
    transition: all 0.5s ease;
}
.empty-rolls-enter-from,
.empty-rolls-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
.empty-rolls-move {
    transition: transform 0.5s ease;
}

.empty-roll-item {
    transition: all 0.5s ease;
}

</style>
