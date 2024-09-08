<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Head} from '@inertiajs/vue3';
import axios from "axios";
import {News} from "@/types";

const {categories} = defineProps<{
    categories:{
        [key: string]: string;
    }
}>()

const allNews = ref<News[]>([])
const categoryNews = ref<Record<string, News[]>>({})
const isNewsLoaded = ref<boolean>(false)

const fetchData = () => {
    isNewsLoaded.value = false
    axios.get(route('news.all'))
        .then((response) => {
            allNews.value = response.data
            isNewsLoaded.value = true
        })
}

const fetchWithCategory = (category:string) => {
    axios.get(route('news.category', { category }))
        .then(response => {
            categoryNews.value[category] = response.data
        })
}

onMounted(() => {
    fetchData()
    for (const category in categories){
        fetchWithCategory(category)
    }
})

</script>

<template>
    <Head title="Homepage"/>
    <GuestLayout>
        <div class="grid grid-cols-1 sm:grid-cols-5 mt-5 gap-3">
            <div>
                <h2 class="text-2xl mb-2 border-b-4 border-neutral-200 dark:border-white/10 dark:text-white/70">News</h2>
                <div v-if="!isNewsLoaded">
                    <div role="status" class="max-w-sm animate-pulse">
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-52 mb-4"></div>
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-64 mb-4"></div>
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-72 mb-4"></div>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div v-else-if="allNews.length">
                    <ul class="space-y-2">
                        <li v-for="news in allNews">
                            <div class="px-2 py-1 border-b border-neutral-200/10">{{ news.title }}</div>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    No results found
                </div>
            </div>
            <div class="sm:col-span-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div v-for="(title,key) in categories">
                    <h2 class="text-2xl mb-2 border-b-4 border-neutral-200 dark:border-white/10 dark:text-white/70">{{ title }}</h2>
                    <div v-if="categoryNews[key]">
                        <ul class="space-y-2">
                            <li v-for="news in categoryNews[key]">
                                <div class="px-2 py-1 border-b border-neutral-200/10">
                                    <img v-if="news.image" :src="news.image" loading="lazy" :alt="news.title"/>
                                    {{ news.title }}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <div role="status" class="max-w-sm animate-pulse">
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-52 mb-4"></div>
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-64 mb-4"></div>
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-72 mb-4"></div>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
