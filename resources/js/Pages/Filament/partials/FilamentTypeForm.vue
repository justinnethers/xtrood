<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col gap-4 text-white">
            <div class="flex flex-col">
                <InputLabel for="name" value="Type" />
                <TextInput name="name" id="name" v-model="form.name" />
            </div>
            <div class="flex flex-col">
                <button class="button" type="submit">Add Filament Type</button>
            </div>
        </div>
    </form>
</template>
<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";

const form = reactive({
    name: '',
})

const emit = defineEmits(['submitted']);

function submit() {
    router.post('/filament-types', form);
    emit('submitted')
}
</script>
