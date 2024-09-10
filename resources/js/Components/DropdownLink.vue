<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    href: string;
}>();
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-500 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
</template>
