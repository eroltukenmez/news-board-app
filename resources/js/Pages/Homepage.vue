<script setup lang="ts">
import {onMounted, ref} from "vue";
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
const firstSection = ref<News[]>([])
const categoryNews = ref<Record<string, News[]>>({})
const isNewsLoaded = ref<boolean>(false)

const fetchData = () => {
    isNewsLoaded.value = false
    axios.get(route('news.all'))
        .then((response) => {
            allNews.value = response.data
            firstSection.value = response.data.filter((news:News) => news.image).slice(0,3)
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
        <!-- First Section -->
        <section class="grid sm:grid-cols-3 grid-cols-1 gap-2" v-if="allNews.length">
            <div class="relative" v-for="data in firstSection">
                <img :src="data.image" :alt="data.title" class="w-full max-h-66 object-cover">
                <div class="absolute bottom-0 left-0 px-2 font-bold text-white bg-gray-700/60">
                    <h4>{{ data.title }}</h4>
                </div>
            </div>
        </section>

        <section class="flex flex-row flex-wrap mt-2" v-for="(category) in Object.entries(categories).slice(0,3)">
            <div class="w-full py-3">
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-bold" >{{ category[1] }}</h2>
            </div>
            <div class="flex flex-row flex-wrap -mx-3">
                <div
                    v-if="categoryNews[category[0]]"
                    v-for="news in categoryNews[category[0]].slice(0,8)"
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

        <section class="">
            <div class="w-full py-3">
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-bold" >Latest news</h2>
            </div>
            <ul class="grid grid-cols-1 sm:grid-cols-3 gap-x-2">
                <li
                    v-if="allNews"
                    v-for="news in allNews"
                    class="border-b border-neutral-600 hover:bg-neutral-500"
                >
                    <a class="text-lg font-bold sm:px-6 py-3 flex flex-row items-center" href="#">{{ news.title }}</a>
                </li>
            </ul>
        </section>

        <section class="flex flex-row flex-wrap mt-2" v-for="(category) in Object.entries(categories).slice(3)">
            <div class="w-full py-3">
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-bold" >{{ category[1] }}</h2>
            </div>
            <div class="flex flex-row flex-wrap -mx-3">
                <div
                    v-if="categoryNews[category[0]]"
                    v-for="news in categoryNews[category[0]].slice(0,8)"
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
