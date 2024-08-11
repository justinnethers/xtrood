<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import RollInformation from "@/Pages/Filament/partials/RollInformation.vue";
import TheFilamentRoll from "@/Components/TheFilamentRoll.vue";

const page = usePage();

const rolls = computed(() => page.props.filamentRolls);
const brand = computed(() => page.props.brand);
const color = computed(() => page.props.color);
const filament_type = computed(() => page.props.filamentType);
// const remainingWeight = computed(() => roll.value.weight - roll.value.usages.reduce((sum, item) => sum + item.weight, 0));
console.log('rolls', rolls);
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h1 class="text-slate-50">
                    {{ brand.name }}
                    <span class="text-2xl">
                    {{ color.name }} {{ filament_type.name }}
                </span>
                </h1>
                <div class="flex-1"></div>
                <TheFilamentRoll :roll="rolls[0]" :rotate="true"/>
            </div>
        </template>

        <div class="">
            <div class="p-8 bg-slate-700 rounded relative shadow-inner">
                <ul class="grid grid-cols-3 gap-6">
                    <li
                        v-for="roll in rolls"
                        class="grid grid-cols-1 px-3 pb-3 bg-gray-300 rounded-md shadow-inner"
                    >
                        <TheFilamentRoll
                            :roll="roll"
                            :rotate="true"
                            class="pt-3 pb-1"
                        />
                        <RollInformation :roll="roll" :show-remaining="false"  />
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
