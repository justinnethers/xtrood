<template>
    <div class="">
        <div v-if="rotate" class="flex flex-col w-[200px] max-w-full items-center">
            <div class="roll h-1.5 bg-black w-full"></div>
            <div
                v-for="i in 15"
                class="h-1 border-b border-slate-900 rounded-full"
                :style="{ backgroundColor: color, width: width + '%' }"
            ></div>
            <div class="roll h-1.5 bg-black w-full"></div>
        </div>
        <div v-else class="flex h-[200px] items-center">
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
    },
    rotate: {
        type: Boolean,
        default: false,
    },
})

const color = computed(() => {
    if (props.roll?.filament.color.hex) {
        return props.roll?.filament.color.hex;
    }
    return props.roll?.filament.color.name;
})

const width = computed(() => {
    if (props.roll?.usages.length > 0) {
        const totalWeight = props.roll.weight;
        const usedWeight = props.roll.usages.reduce((sum, item) => sum + item.weight, 0);
        const remainingWeight = totalWeight - usedWeight;
        const percentageRemaining = (remainingWeight / totalWeight) * 100;

        if (remainingWeight <= 0) {
            return (60 / 185) * 95; // Adjust the calculation for the new base percentage
        }

        const fullWidthPercentage = 95; // Full width at 95%
        const emptyWidthPercentage = (60 / 185) * 95; // Convert 60px to percentage of the new base width
        const widthRangePercentage = fullWidthPercentage - emptyWidthPercentage;

        const width = emptyWidthPercentage + (percentageRemaining / 100 * widthRangePercentage);

        console.log('remainingWeight', remainingWeight, 'totalWeight', totalWeight, 'percentageRemaining', percentageRemaining, 'calculatedWidth', width);
        return Math.round(width * 100) / 100; // Round to two decimal places for precision
    }
    return 95; // Full width as percentage at 95%
});

const height = computed(() => {
    if (props.roll?.usages.length > 0) {
        const totalWeight = props.roll.weight;
        const usedWeight = props.roll.usages.reduce((sum, item) => sum + item.weight, 0);
        const remainingWeight = totalWeight - usedWeight;
        const percentageRemaining = remainingWeight / totalWeight;

        if (remainingWeight <= 0) {
            return 60;
        }

        const fullHeight = 185;
        const emptyHeight = 60;
        const heightRange = fullHeight - emptyHeight;

        const height = emptyHeight + (percentageRemaining * heightRange);

        console.log('remainingWeight', remainingWeight, 'totalWeight', totalWeight, 'percentageRemaining', percentageRemaining, 'calculatedHeight', height);
        return Math.round(height);
    }
    return props.height;
})
</script>
