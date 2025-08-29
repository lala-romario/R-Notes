<template>
    <header class="items-center w-full bg-teal-800 py-4 px-5">
        <nav class="flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <div class="w-auto">
                <h1 class="text-lg sm:text-xl text-cyan-200 font-semibold">R-Notes</h1>
            </div>

            <!-- Liens -->
            <div class="flex items-center gap-4 sm:gap-8 lg:gap-12">
                <a @click="toCreateNote()"
                    class="text-base sm:text-lg text-white hover:text-neutral-400 duration-300 cursor-pointer">
                    Create note
                </a>
                <a @click="logout()"
                    class="text-base sm:text-lg text-white hover:text-neutral-400 duration-300 cursor-pointer">
                    Log out
                </a>
            </div>
        </nav>
    </header>

    <!-- Notes -->
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl sm:text-3xl font-bold mb-6">My Notes</h1>

        <!-- Ajout de items-start pour hauteur indépendante -->
        <div v-if="notes" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 items-start">
            <div v-for="note in notes" :key="note.id"
                class="group p-4 border border-gray-200 rounded-xl shadow hover:shadow-xl transition duration-300 flex flex-col justify-between">
                <div>
                    <h1 class="text-base sm:text-lg text-neutral-500 font-bold">
                        {{ user.name }}
                    </h1>
                    <h2 class="text-lg sm:text-xl font-semibold text-teal-600">
                        {{ note.title }}
                    </h2>

                    <!-- Contenu avec animation smooth -->
                    <p
                        class="text-gray-700 mt-2 overflow-hidden transition-all duration-500 ease-in-out max-h-20 group-hover:max-h-[1000px]">
                        {{ note.content }}
                    </p>

                    <!-- Image -->
                    <div v-if="note.file_URL" class="mt-2">
                        <img :src="note.file_URL" alt="note image" class="object-contain h-40 w-full rounded-lg" />
                    </div>

                    <div v-if="note.video">
                        <video :src="note.video" class="rounded-md" controls></video>
                    </div>

                    <!-- Date -->
                    <div class="mt-3 text-xs sm:text-sm text-gray-400">
                        Created at: {{ useDateFormat(note.created_at) }}
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end mt-4">
                    <button @click="deleteNote(note.id)"
                        class="px-3 py-2 text-sm sm:text-base bg-red-500 hover:bg-red-600 text-white rounded-lg shadow transition">
                        Delete
                    </button>
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
            console.log(response.data.code)
        })
        .catch(error => console.log(error))
}

const deleteNote = async (noteId) => {
    const response = await axios.post('http://localhost:8000/api/delete/note', { noteId },
        {
            headers: {
                Authorization: `${localStorage.getItem('token')}`
            }
        }
    )

    if (response.data.code !== 200) {
        router.push('/')
    }

    router.push('/dashboard')

    console.log(response.data)
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
