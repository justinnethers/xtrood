<template>
    <div class="flex flex-col w-full">
        <div class="text-2xl">
            <div v-if="multipleRolls">
                <Link :href="route('filament.show-color', {color: roll.filament.color.id, brand: roll.filament.brand.id, filament_type: roll.filament.filament_type.id})" class="cursor-pointer hover:underline">
                    <h3>{{ roll.filament.brand.name }}</h3>
                    <p>{{ roll.filament.color.name }} {{ roll.filament.filament_type.name }}</p>
                </Link>
            </div>
            <div v-else>
                <Link :href="route('filament.show', {filamentRoll: roll.id})" class="cursor-pointer hover:underline">
                    <h3>{{ roll.filament.brand.name }}</h3>
                    <p>{{ roll.filament.color.name }} {{ roll.filament.filament_type.name }}</p>
                </Link>
            </div>
            <p v-if="showRemaining">
                <span v-if="remainingWeight">
                    ~<span class="font-bold">{{ remainingWeight }}g</span> left
                </span>
                <span v-else>
                    <span class="font-bold">Empty</span>
                </span>
            </p>
        </div>
        <div class="flex-1"></div>
        <div v-if="!isEmpty" class="flex text-sm font-medium">
            <div class="flex-1"></div>
            <button @click="useRoll" class="button">Use Roll</button>
        </div>
        <Modal :show="showUsageModal" @close="showUsageModal = false">
            <div class="p-8">
                <FilamentUsageForm :filament-roll-id="roll.id" @submitted="showUsageModal = false"/>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import {computed, defineProps, ref} from 'vue';
import Modal from "@/Components/Modal.vue";
import FilamentUsageForm from "@/Pages/Filament/partials/FilamentUsageForm.vue";
import { Link } from '@inertiajs/vue3';

const showUsageModal = ref(false);

const props = defineProps({
    roll: {
        type: Object,
        required: true,
    },
    showRemaining: {
        type: Boolean,
        default: true,
    },
    isEmpty: {
        type: Boolean,
        default: false,
    },
    multipleRolls: {
        type: Boolean,
        default: false,
    }
});

const remainingWeight = computed(() => {
    const weight = props.roll?.weight - props.roll?.usages.reduce((sum, item) => sum + item.weight, 0);
    return Math.max(0, weight);
})

function useRoll() {
    showUsageModal.value = true;
}

</script>
