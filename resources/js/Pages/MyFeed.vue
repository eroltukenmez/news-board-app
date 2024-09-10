<script setup lang="ts">
import {onMounted, ref} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Head, usePage} from '@inertiajs/vue3';
import axios from "axios";
import {News} from "@/types";
import UpdateFeedOptionsForm from "@/Pages/Profile/Partials/UpdateFeedOptionsForm.vue";
import NavLink from "@/Components/NavLink.vue";

const categoryNews = ref<Record<string, News[]>>({})
const feed = usePage().props.auth.user.feed

const fetchWithCategory = (category:string) => {
    axios.get(route('news.my-feed-data', {
        category,
        sources:feed.sources,
        pageSize:12
    }))
        .then(response => {
            categoryNews.value[category] = response.data
        })
}

onMounted(() => {
    feed.categories.forEach (category => {
        fetchWithCategory(category)
    })
})

</script>

<template>
    <Head title="My News Feed"/>
    <GuestLayout>
        <section class="h-screen" v-if="!feed.categories.length">
            <div class="w-full text-center p-6">
                Please select your preferred categories on your <NavLink :href="route('profile.edit')">Profile</NavLink> page to personalize your My Feed experience.
            </div>
        </section>

        <section class="flex flex-row flex-wrap mt-2" v-for="(category) in feed.categories">
            <div class="w-full py-3">
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-bold" >{{ category.toUpperCase() }}</h2>
            </div>
            <div class="flex flex-row flex-wrap -mx-3">
                <div
                    v-if="categoryNews[category]"
                    v-for="news in categoryNews[category]"
                    class="flex-shrink max-w-full w-full sm:w-1/3 lg:w-1/4 px-3 pb-3 pt-3 sm:pt-0 border-b-2 sm:border-b-0 border-dotted"
                >
                    <div class="flex flex-row sm:block">
                        <a href="">
                            <img v-if="news.image" class="sm:max-w-full max-w-52 h-22 sm:h-44 sm:w-full mx-auto object-cover" :src="news.image" :alt="news.title">
                        </a>
                        <div class="py-0 sm:py-3 pl-3 sm:pl-0">
                            <h3 class="text-lg font-bold leading-tight mb-2 text-neutral-900 dark:text-neutral-200">
                                <a href="#">{{ news.title }}</a>
                            </h3>
                            <p class="hidden md:block text-gray-600 dark:text-neutral-400 leading-tight mb-1">{{ news.content.substring(0,200) }}</p>
                            <span class="inline-block h-3 border-l-2 border-red-600 mr-2"></span> {{ news.date }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </GuestLayout>
</template>
