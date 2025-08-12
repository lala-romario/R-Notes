<template>
    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-cyan-200 font-semibold">R-Notes</h1>
            </div>

            <div class="flex pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex">
                    <div class="flex">
                        <ul class="flex list-none space-x-10 lg:space-x-20">
                            <li><a @click="toCreateNote()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Create
                                    note</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex lg:ml-150">
                    <div class="flex">
                        <a @click="logout()"
                            class="text-white text-xl hover:text-neutral-500 duration-500 cursor-pointer">Log out</a>
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
                <h1 class="text-xl text-neutral-500 font-bold">{{ user.name }}</h1>
                <h2 class="text-xl font-semibold text-teal-600">{{ note.title }}</h2>
                <p class="text-gray-700 mt-2 line-clamp-3">{{ note.content }}</p>

                <div v-if="note.file_URL">
                    <img :src="note.file_URL" alt="" class="object-none h-48 w-auto rounded">
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
    <p>{{ token }}</p>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useDateFormat } from '@vueuse/core';


const token = localStorage.getItem('token')
const notes = ref(null)
const user = ref('')
const code = ref()

const router = useRouter();

const toCreateNote = () => {
    if (localStorage.getItem('token') != '') {
        router.push('/create/note');
    }
}

//get all notes from endpoint
{
    axios.get('http://localhost:8000/api/dashboard',
        {
            headers: {
                Authorization: `${localStorage.getItem('token')}`
            }
        })
        .then(response => {
            notes.value = response.data.notes
            user.value = response.data.user
            code.value = response.data.code

            if (!(code.value === 200)) {
                router.push('/')
            }
            console.log(code.value)
        })
        .catch(error => console.log('error'))


}

const logout = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/logout',
            {
                headers: {
                    Authorization: `${localStorage.getItem('token')}`
                }
            }
        )

        if (response.data.code === 200) {
            router.push('/')
        }
    } catch (error) {
        console.log(error)
    }
}
</script>
