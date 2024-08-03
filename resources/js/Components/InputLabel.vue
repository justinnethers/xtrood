<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block font-bold text-gray-700 dark:text-gray-300 uppercase text-xs leading-tight md:leading-loose">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
