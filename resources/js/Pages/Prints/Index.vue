<template>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-slate-50">
                Prints
            </h1>
        </template>
        <div>
            <div class="p-8 bg-slate-700 rounded text-white">
                <h2>Prints</h2>
                <p>This is the prints page</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
