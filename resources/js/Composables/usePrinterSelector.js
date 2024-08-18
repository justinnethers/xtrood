import { ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export default function usePrinterSelector() {
    const page = usePage();
    const localPrinterId = ref('');

    const initFromUrl = () => {
        const urlParams = new URLSearchParams(window.location.search);
        localPrinterId.value = urlParams.get('printer_id') || '';
    };

    initFromUrl();

    const printer_id = computed({
        get: () => localPrinterId.value,
        set: (newValue) => {
            localPrinterId.value = newValue;
            updateUrl(newValue);
        }
    });

    const updateUrl = (newPrinterId) => {
        router.get(
            route(route().current()),
            { ...route().params, printer_id: newPrinterId },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                only: ['printers'] // Adjust based on what data needs to be refreshed
            }
        );
    };

    // Watch for Inertia navigation events
    watch(() => page.url, () => {
        initFromUrl();
    });

    return {
        printer_id,
        printers: computed(() => page.props.printers)
    };
}
