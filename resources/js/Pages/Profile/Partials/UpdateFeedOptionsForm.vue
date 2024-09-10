<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Checkbox from "@/Components/Checkbox.vue";

defineProps<{
    categories: { [key: string]: string; };
}>();

const sources = usePage().props.news_sources
const user = usePage().props.auth.user;

const form = useForm({
    feed: user.feed ? user.feed : {
        sources:[],
        categories:[]
    },
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Profile Feed Option</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-300">
                Update your account's profile feed options.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.feed-update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel value="Sources" />
                <label class="flex items-center" v-for="(title,key) in sources">
                    <Checkbox :value="key" v-model:checked="form.feed.sources" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-200">{{ title }}</span>
                </label>
            </div>

            <div>
                <InputLabel value="Categories" />
                <label class="flex items-center" v-for="(title,key) in categories">
                    <Checkbox :value="key" v-model:checked="form.feed.categories" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-200">{{ title }}</span>
                </label>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
