<template>
    <div>
        <div class="flex h-[200px] items-center">
            <div class="roll w-1.5 bg-black h-[200px]"></div>
            <div
                v-for="i in 15"
                class="w-1 border-r border-slate-900 rounded-full"
                :style="{ backgroundColor: color, height: height + 'px' }"
            ></div>
            <div class="roll w-1.5 bg-black h-[200px]"></div>
        </div>
    </div>
</template>

<script setup>
import {computed, defineProps} from 'vue';

const props = defineProps({
    height: {
        type: Number,
        default: 180,
    },
    roll: {
        type: Object,
        required: true,
    }
})

const color = computed(() => {
    if (props.roll.filament.color.hex) {
        return props.roll.filament.color.hex;
    }
    return props.roll.filament.color.name;
})

const height = computed(() => {
    if (props.roll.usages.length > 0) {
        const weight = props.roll.weight - props.roll.usages.reduce((sum, item) => sum + item.weight, 0);
        console.log('weight', weight, props.roll.weight, (weight / props.roll.weight), (weight / props.roll.weight) * props.height)
        return Math.round((weight / props.roll.weight) * props.height);
    }
    return props.height;
})
</script>
