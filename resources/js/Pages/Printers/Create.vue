<template>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-slate-50">Add New Printer</h1>
        </template>

        <div class="p-8 bg-slate-700 rounded">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <InputLabel for="name" value="Printer Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <InputLabel for="brand" value="Brand" />
                        <TextInput id="brand" v-model="form.brand" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <InputLabel for="model" value="Model" />
                        <TextInput id="model" v-model="form.model" type="text" class="mt-1 block w-full" required />
                    </div>


                    <div>
                        <InputLabel for="purchase_date" value="Purchase Date" />
                        <TextInput id="purchase_date" v-model="form.purchase_date" type="date" class="mt-1 block w-full" />
                    </div>

                    <div>
                        <InputLabel for="purchase_price" value="Purchase Price" />
                        <TextInput id="purchase_price" v-model="form.purchase_price" type="number" step="0.01" class="mt-1 block w-full" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="button">Add Printer</button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {computed, reactive} from 'vue';
import {router, usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const page = usePage()

const brands = computed(() => page.props.brands);

const form = reactive({
    name: '',
    brand_id: '',
    model: '',
    bed_size_x: '',
    bed_size_y: '',
    bed_size_z: '',
});

function submit() {
    router.post(route('user-printers.store'), form);
}
</script>
