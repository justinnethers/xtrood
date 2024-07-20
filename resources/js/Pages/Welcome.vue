<script setup>
import { Head, Link } from '@inertiajs/vue3';
import FilamentRoll from "@/Components/FilamentRoll.vue";

defineProps({
    filamentRolls: {
        type: Array,
        required: true
    },
    user: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <Head title="Welcome" />
    <div class="bg-slate-700 h-screen w-screen p-8">
        <div>
            <h1>huehrgi</h1>
            <pre>{{ user }}</pre>
            <pre>{{ filamentRolls }}</pre>
        </div>
        <div class="flex gap-4">
            <FilamentRoll color="green" />
            <FilamentRoll color="red" height="125px" />
            <FilamentRoll color="purple" height="90px" />
        </div>
    </div>
</template>
