<script setup lang="ts">
import {onMounted, ref, watch} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Head} from '@inertiajs/vue3';
import axios from "axios";
import {News} from "@/types";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const {source} = defineProps<{
    source:string,
    title:string
}>()

const allNews = ref<News[]>([])
const page = ref<number>(1)
const sort = ref<string>('newest')
const isLoading = ref(false)

const fetchData = () => {
    isLoading.value = true
    axios.get(route('news.sources.data',source),{
        params:{
            pageSize:12,
            page:page.value,
            sortBy:sort.value
        }
    })
        .then((response) => {
            allNews.value = response.data
            isLoading.value = false
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
}

onMounted(() => {
    fetchData()
})
watch(
    () => page.value,
    ( ) => fetchData()
)
watch(
    () => sort.value,
    ( ) => {
        page.value = 1
        fetchData()
    }
)

</script>

<template>
    <Head :title="title"/>
    <GuestLayout>
        <h2 class="text-6xl font-bold mb-5">{{ title }}</h2>

        <div class="mb-5">
            Sort by:
            <Dropdown align="left" content-classes="py-1 bg-white dark:bg-neutral-200">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:bg-neutral-200 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                            {{ sort.toUpperCase() }}

                            <svg
                                class="ms-2 -me-0.5 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <div
                        @click="sort = 'newest'"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                    >
                        Newest
                    </div>
                    <div
                        @click="sort = 'relevancy'"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                    >
                        Relevancy
                    </div>
                </template>
            </Dropdown>

        </div>

        <section class="flex flex-row flex-wrap -mx-3 min-h-screen">
            <div
                v-if="allNews"
                v-for="news in allNews"
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
                        <div><span class="inline-block h-3 border-l-2 border-red-600 mr-2"></span> {{ news.categories.join(', ').toUpperCase() }}</div>
                        <div><span class="inline-block h-3 border-l-2 border-red-600 mr-2"></span> {{ news.date }}</div>
                    </div>
                </div>
            </div>
        </section>
        <div class="my-5 flex justify-between">
            <PrimaryButton :disabled="isLoading" @click="page = (page > 1 ? --page : 1)">Previous</PrimaryButton>
            <PrimaryButton :disabled="isLoading" @click="page++">Next</PrimaryButton>
        </div>
    </GuestLayout>
</template>
