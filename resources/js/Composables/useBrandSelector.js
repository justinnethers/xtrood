import { ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export default function useBrandSelector() {
    const page = usePage();
    const localBrandId = ref('');

    const initFromUrl = () => {
        const urlParams = new URLSearchParams(window.location.search);
        localBrandId.value = urlParams.get('brand_id') || '';
    };

    initFromUrl();

    const brand_id = computed({
        get: () => localBrandId.value,
        set: (newValue) => {
            localBrandId.value = newValue;
            updateUrl(newValue);
        }
    });

    const updateUrl = (newBrandId) => {
        router.get(
            route(route().current()),
            { ...route().params, brand_id: newBrandId },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                only: ['brands'] // Adjust based on what data needs to be refreshed
            }
        );
    };

    // Watch for Inertia navigation events
    watch(() => page.url, () => {
        initFromUrl();
    });

    return {
        brand_id,
        brands: computed(() => page.props.brands)
    };
}
