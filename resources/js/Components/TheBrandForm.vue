<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col gap-4 text-white">
            <div class="flex flex-col">
                <InputLabel for="name" value="Name" />
                <TextInput name="name" id="name" v-model="form.name" />
            </div>
            <div class="flex flex-col">
                <button class="button" type="submit">Add Brand</button>
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
    }
});

const form = reactive({
    name: '',
    type: props.type
})

const emit = defineEmits(['submitted']);

function submit() {
    router.post('/brands', form);
    emit('submitted')
}
</script>
