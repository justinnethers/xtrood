<template>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-slate-50">Add New Printer</h1>
            <p class="text-white">It looks like your printer collection is growing! Keep up the good work.</p>
        </template>

        <div>
            <Modal :show="showModals['brand']" @close="showModals['brand'] = false">
                <div class="p-8">
                    <h2 class="text-slate-50">Add a brand</h2>
                    <TheBrandForm type="printer" @submitted="showModals['brand'] = false" />
                </div>
            </Modal>

            <Modal :show="showModals['printer']" @close="showModals['printer'] = false">
                <div class="p-8">
                    <h2 class="text-slate-50">Add a printer</h2>
                    <ThePrinterForm :brand_id="brand_id" @submitted="showModals['printer'] = false" />
                </div>
            </Modal>

            <div class="p-8 bg-slate-700 rounded">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <InputLabel for="nickname" value="Printer Nickname" />
                            <TextInput id="nickname" v-model="form.nickname" type="text" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <InputLabel for="brand" value="Brand" />
                            <select
                                name="brand_id"
                                id="brand_id"
                                v-on:change="handleAdd($event, 'brand'),handleChange($event)"
                                v-model="form.brand_id"
                                class="w-full"
                            >
                                <option value="" selected>Select a brand</option>
                                <option v-for="(name, id) in brands" :value="id">{{ name }}</option>
                                <option value="add">Add a brand</option>
                            </select>
                            <!--                        <TextInput id="printer" v-model="form.brand" type="text" class="mt-1 block w-full" required />-->
                        </div>

                        <div>
                            <InputLabel for="model" value="Model" />
                            <select
                                name="printer_id"
                                id="printer_id"
                                v-on:change="handleAdd($event, 'printer'),handleChange($event, 'printer')"
                                v-model="form.printer_id"
                                class="w-full"
                                :disabled="!brand_id"
                            >
                                <option value="" selected>Select a printer</option>
                                <option v-for="printer in printersOfBrand" :value="printer.id">{{ printer.name }}</option>
                                <option value="add">Add a printer</option>
                            </select>

<!--                            <TextInput id="model" v-model="form.model" type="text" class="mt-1 block w-full" required />-->
                        </div>

                        <div>
                            <InputLabel for="purchase_date" value="Purchase Date" />
                            <TextInput id="purchase_date" v-model="form.purchase_date" type="date" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <InputLabel for="purchase_price" value="Purchase Price" />
                            <TextInput id="purchase_price" v-model.number="form.purchase_price" type="number" step="0.01" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="button">Add Printer</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {computed, nextTick, onMounted, reactive, ref, watch} from 'vue';
import {router, usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from "@/Components/Modal.vue";
import TheBrandForm from "@/Components/TheBrandForm.vue";
import ThePrinterForm from "@/Components/ThePrinterForm.vue";
import useBrandSelector from "@/Composables/useBrandSelector.js";
import usePrinterSelector from "@/Composables/usePrinterSelector.js";

const page = usePage()

const { brand_id, brands } = useBrandSelector();
const { printer_id, printers } = usePrinterSelector();

const printersOfBrand = computed(() => {
    return printers.value.filter(printer => printer.brand_id == brand_id.value);
});

const form = reactive({
    nickname: '',
    brand_id: '',
    printer_id: '',
    purchase_date: '',
    purchase_price: '',
});

const showModals = ref({
    brand: false,
    printer: false
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

const handleChange = (event, type='brand') => {
    const id = event.target.value;
    console.log('handleChange', type, id);
    if (id === 'add') return;

    if (type === 'brand') {
        form.brand_id = id;
        brand_id.value = id;
    } else {
        form.printer_id = id;
        printer_id.value = id;
    }
    nextTick()
}

const submit = () => {
    router.post(route('user-printers.store'), form);
}

watch(brand_id, (newValue) => {
    form.brand_id = newValue;
})

watch(printer_id, (newValue) => {
    form.printer_id = newValue;
})

onMounted(() => {
    form.brand_id = brand_id.value;
    form.printer_id = printer_id.value;
})
</script>
