<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import FilamentRoll from "@/Components/FilamentRoll.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {computed, onMounted, reactive, ref} from "vue";
import Modal from "@/Components/Modal.vue";
import BrandForm from "@/Pages/Filament/partials/BrandForm.vue";
import ColorForm from "@/Pages/Filament/partials/ColorForm.vue";
import FilamentTypeForm from "@/Pages/Filament/partials/FilamentTypeForm.vue";

const page = usePage()

const brands = computed(() => page.props.brands);
const filamentTypes = computed(() => page.props.filamentTypes);
const colors = computed(() => page.props.colors);

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

const showModals = ref({
    brand: false,
    color: false,
    filamentType: false,
});

const handleAdd = (event, type) => {
    const id = event.target.value;
    console.log(id, type)
    if (id === 'add') {
        showModals.value[type] = true;
    } else {
        showModals.value[type] = false;
    }
}

function submit() {
    router.post('/filament', form);
    console.log(form);

}
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-slate-50">Add Roll of Filament</h1>
        </template>

        <div>
            <Modal :show="showModals['brand']" @close="showModals['brand'] = false">
                <div class="p-8">
                    <h2 class="text-slate-50">Add a brand</h2>
                    <BrandForm @submitted="showModals['brand'] = false" />
                </div>
            </Modal>

            <Modal :show="showModals['color']" @close="showModals['color'] = false">
                <div class="p-8">
                    <h2 class="text-slate-50">Add a color</h2>
                    <ColorForm @submitted="showModals['color'] = false" />
                </div>
            </Modal>

            <Modal :show="showModals['filamentType']" @close="showModals['filamentType'] = false">
                <div class="p-8">
                    <h2 class="text-slate-50">Add a filament type</h2>
                    <FilamentTypeForm @submitted="showModals['filamentType'] = false" />\
                </div>
            </Modal>

            <div class="bg-slate-700 rounded">
                <form @submit.prevent="submit" class="p-8">
                    <div class="flex flex-col gap-4 text-white">
                        <div class="flex gap-4">
                            <div class="flex flex-col flex-1">
                                <InputLabel for="brand" value="Brand" />
                                <select
                                    name="brand_id"
                                    id="brand_id"
                                    v-on:change="handleAdd($event, 'brand')"
                                    v-model="form.brand_id"
                                >
                                    <option value="" selected>Select a brand</option>
                                    <option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>
                                    <option value="add">Add a brand</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1">
                                <InputLabel for="color" value="Color" />
                                <select
                                    name="color_id"
                                    id="color_id"
                                    v-on:change="handleAdd($event, 'color')"
                                    v-model="form.color_id"
                                >
                                    <option value="" selected>Select a color</option>
                                    <option v-for="color in colors" :value="color.id">{{ color.name }}</option>
                                    <option value="add">Add a color</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col flex-1">
                                <InputLabel for="material" value="Material" />
                                <select
                                    name="filament_type_id"
                                    id="filament_type_id"
                                    v-on:change="handleAdd($event, 'filamentType')"
                                    v-model="form.filament_type_id"
                                >
                                    <option value="" selected>Select a material</option>
                                    <option v-for="type in filamentTypes" :value="type.id">{{ type.name }}</option>
                                    <option value="add">Add a filament type</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1">
                                <InputLabel for="weight" value="Weight (in grams)" />
                                <TextInput name="weight" id="weight" model-value="1000" v-model="form.weight" />
                            </div>
                            <div class="flex flex-col flex-1">
                                <InputLabel for="diameter" value="Diameter" />
                                <select name="diameter" id="diameter" v-model="form.diameter">
                                    <option value="1.75">1.75mm</option>
                                    <option value="2.85">2.85mm</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col flex-1">
                                <InputLabel for="price" value="Price" />
                                <TextInput name="price" id="price" />
                            </div>
                            <div class="flex flex-col flex-1">
                                <InputLabel for="purchase_date" value="Purchase Date" />
                                <TextInput type="date" id="purchase_date" name="purchase_date" />
                            </div>
                            <div class="flex flex-col flex-1">
                                <InputLabel for="purchase_location" value="Purchase Location" />
                                <TextInput name="purchase_location" id="purchase_location" />
                            </div>
                        </div>


                        <div class="flex flex-col">
                            <InputLabel for="notes" value="Notes" />
                            <textarea name="notes" id="notes" />
                        </div>
                        <div class="flex flex-col">
                            <button class="button" type="submit">Add Roll</button>
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
        </div>
    </AuthenticatedLayout>
</template>
