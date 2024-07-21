<template>
    <div>
        <h1 class="text-slate-50">Print Something Cool</h1>
        <form @submit.prevent="submit" class="grid grid-cols-1 gap-3">
            <div>
                <InputLabel for="weight" value="Amount Used (in g)" />
                <TextInput autofocus type="number" id="weight" v-model="form.weight" class="w-full" />
            </div>
            <div class="flex flex-col text-slate-50">
                <button class="button" type="submit">Print Something</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import {reactive} from 'vue';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    filamentRollId: {
        type: Number,
        required: true,
    }
});

const form = reactive({
    filament_roll_id: props.filamentRollId,
    weight: '',
});

const emit = defineEmits(['submitted']);

function submit() {
    router.post('/filament/use', form);
    emit('submitted')
};

</script>
