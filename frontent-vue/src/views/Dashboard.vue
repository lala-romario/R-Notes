<template>
    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-cyan-200 font-semibold">R-Notes</h1>
            </div>

            <div class="flex justify-end pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex justify-end">
                    <div class="flex">
                        <ul class="flex list-none space-x-10 lg:space-x-20">
                            <li><a @click="toCreateNote()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Create
                                    note</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>


    <div class="max-w-200 mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">My Notes</h1>
        <div v-if="notes" class="grid gap-4">
            <div v-for="note in notes" :key="note.id"
                class="p-4 border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-600">
                <h2 class="text-xl font-semibold text-teal-600">{{ note.title }}</h2>
                <p class="text-gray-700 mt-2 line-clamp-3">{{ note.content }}</p>

                <div v-if="note.file_URL">
                    <img :src="note.file_URL" alt="" class="object-cover h-48 w-96 rounded">
                </div>

                <!--<div v-if="note.video" class="mt-2">
                    <video :src="note.video" class="h-48 w-96"></video>
                </div>-->
                <div class="mt-4 text-sm text-gray-400">
                    Created at: {{ useDateFormat(note.created_at) }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useDateFormat } from '@vueuse/core';


const notes = ref(null)
//get all notes from endpoint
{
    axios.get('http://localhost:8000/api/dashboard')
        .then(response => {
            notes.value = response.data

        })
        .catch(error => console.log('error'))
}



const router = useRouter();

const toCreateNote = () => {
    router.push('/create/note');
}
</script>
