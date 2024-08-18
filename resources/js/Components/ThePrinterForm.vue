<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col gap-4 text-white">
            <div class="flex flex-col">
                <InputLabel for="name" value="Name" />
                <TextInput name="name" id="name" v-model="form.name" />
            </div>
            <div>
                <InputLabel for="bed_size_x" value="Bed Size X (mm)" />
                <TextInput id="bed_size_x" v-model.number="form.bed_size_x" type="number" class="mt-1 block w-full" required />
            </div>

            <div>
                <InputLabel for="bed_size_y" value="Bed Size Y (mm)" />
                <TextInput id="bed_size_y" v-model.number="form.bed_size_y" type="number" class="mt-1 block w-full" required />
            </div>

            <div>
                <InputLabel for="bed_size_z" value="Bed Size Z (mm)" />
                <TextInput id="bed_size_z" v-model.number="form.bed_size_z" type="number" class="mt-1 block w-full" required />
            </div>

            <div class="flex flex-col">
                <button class="button" type="submit">Add Printer</button>
            </div>
        </div>
    </form>
</template>
<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    type: {
        type: String,
        required: true
    },
    brand_id: {
        type: Number,
        required: true
    }
});

const form = reactive({
    name: '',
    bed_size_x: 0,
    bed_size_y: 0,
    bed_size_z: 0,
    brand_id: props.brand_id
})

const emit = defineEmits(['submitted']);

function submit() {
    router.post('/3d-printers', form);
    emit('submitted')
}
</script>
