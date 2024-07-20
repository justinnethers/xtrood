<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import FilamentRoll from "@/Components/FilamentRoll.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {onMounted, reactive, ref} from "vue";
import Modal from "@/Components/Modal.vue";
import BrandForm from "@/Pages/Filament/partials/BrandForm.vue";
import ColorForm from "@/Pages/Filament/partials/ColorForm.vue";

defineProps({
    filamentRolls: {
        type: Array,
    },
    brands: {
        type: Object,
        required: true,
    },
    filamentTypes: {
        type: Object,
        required: true,
    },
    colors: {
        type: Object,
        required: true,
    },
});

const form = reactive({
    brand_id: '',
    color_id: '',
    filament_type_id: '1',
    weight: '1000',
    diameter: '1.75',
    price: '',
    purchase_date: '',
    purchase_location: '',
    notes: '',
});

const showBrandModal = ref(false);
const showColorModal = ref(false);

function submit() {
    router.post('/filament', form);
    console.log(form);

}
const handleBrand = (event) => {
    const brandId = event.target.value;

    if (brandId === 'add') {
        console.log('add brand');
        showBrandModal.value = true;
    } else {
        showBrandModal.value = false;
    }
}

const handleColor = (event) => {
    const colorId = event.target.value;
    console.log(colorId);

    if (colorId === 'add') {
        console.log('add color');
        showColorModal.value = true;
    } else {
        showColorModal.value = false;
    }
}
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >My Filament</h2>
        </template>
        <Modal :show="showBrandModal" @close="showBrandModal = false">
            <div class="p-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Add a brand
                </h2>
                <BrandForm @submitted="showBrandModal = false" />
            </div>
        </Modal>

        <Modal :show="showColorModal" @close="showColorModal = false">
            <div class="p-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Add a color
                </h2>
                <ColorForm @submitted="showColorModal = false" />
            </div>
        </Modal>

        <div class="p-12 bg-slate-800 m-8">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 text-white">
                    <div class="flex flex-col">
                        <InputLabel for="brand" value="Brand" />
                        <select name="brand_id" id="brand_id" v-on:change="handleBrand" v-model="form.brand_id">
                            <option value="" selected>Select a brand</option>
                            <option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>
                            <option value="add">Add a brand</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="color" value="Color" />
                        <select name="color_id" id="color_id" v-on:change="handleColor" v-model="form.color_id">
                            <option value="" selected>Select a color</option>
                            <option v-for="color in colors" :value="color.id">{{ color.name }}</option>
                            <option value="add">Add a color</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="material" value="Material" />
                        <select name="filament_type_id" id="filament_type_id" v-model="form.filament_type_id">
                            <option value="" selected>Select a material</option>
                            <option v-for="type in filamentTypes" :value="type.id">{{ type.name }}</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="weight" value="Weight (in grams)" />
                        <TextInput name="weight" id="weight" model-value="1000" v-model="form.weight" />
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="diameter" value="Diameter" />
                        <select name="diameter" id="diameter" v-model="form.diameter">
                            <option value="1.75">1.75mm</option>
                            <option value="2.85">2.85mm</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="price" value="Price" />
                        <TextInput name="price" id="price" />
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="purchase_date" value="Purchase Date" />
                        <TextInput type="date" id="purchase_date" name="purchase_date" />
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="purchase_location" value="Purchase Location" />
                        <TextInput name="purchase_location" id="purchase_location" />
                    </div>
                    <div class="flex flex-col">
                        <InputLabel for="notes" value="Notes" />
                        <textarea name="notes" id="notes" />
                    </div>
                    <div class="flex flex-col">
                        <button type="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <ul>
                <li v-for="color in colors">
                    <div class="hidden">bg-[{{ color.hex }}]X</div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
