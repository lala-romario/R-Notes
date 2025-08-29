<template>
    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <div class="w-auto">
                <h1 class="text-xl sm:text-2xl text-cyan-200 font-semibold">R-Notes</h1>
            </div>

            <!-- Liens -->
            <div class="flex flex-wrap items-center gap-6 sm:gap-10 lg:gap-20 mt-4 lg:mt-0">
                <a @click="toDashboard()"
                    class="text-base sm:text-lg text-white hover:text-neutral-500 duration-300 cursor-pointer">
                    Dashboard
                </a>
                <a class="text-base sm:text-lg text-white hover:text-neutral-500 duration-300 cursor-pointer">
                    Log out
                </a>
            </div>
        </nav>
    </header>

    <div class="mb-10 px-4">
        <div class="flex justify-center mt-10">
            <div class="w-full max-w-2xl shadow-lg p-6 space-y-8 rounded bg-gray-100">
                <h1 class="text-neutral-600 text-2xl sm:text-3xl font-semibold">
                    Create a new note
                </h1>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-gray-600 text-lg sm:text-xl">Title</label>
                    <input type="text" name="title" id="title" v-model="schema.title.$value" placeholder="Title"
                        @focus="titleError = schema.title.$error.message"
                        class="w-full mt-2 border border-neutral-800 rounded h-12 px-3" />
                    <p v-if="schema.title.$error" class="mt-2 text-red-600">{{ titleError }}</p>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-gray-600 text-lg sm:text-xl">Content</label>
                    <textarea name="content" id="content" placeholder="Type your text here"
                        v-model="schema.content.$value" @focus="contentError = schema.content.$error.message"
                        class="w-full mt-2 border border-neutral-800 p-3 h-32 rounded resize-y"></textarea>
                    <p v-if="schema.content.$error" class="mt-2 text-red-600">{{ contentError }}</p>
                </div>

                <!-- Upload file -->
                <div class="flex items-center justify-center w-full">
                    <label for="file"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 duration-300">
                        <div class="flex flex-col items-center justify-center pt-4 pb-4">
                            <svg class="w-8 h-8 mb-3 text-gray-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>

                            <p class="mb-1 text-sm text-neutral-500">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-sm text-gray-600" v-if="selectedFile">{{ selectedFile.name }}</p>
                            <p class="text-xs text-red-500" v-if="fileError">{{ fileError }}</p>
                        </div>
                        <input id="file" type="file" name="file" class="hidden" @change="handleChange" />
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-center sm:justify-between">
                    <button type="submit" @click.prevent="storeNote()"
                        class="w-full sm:w-auto text-white text-lg px-6 py-2 bg-teal-700 hover:bg-teal-800 shadow-md duration-300 rounded">
                        Save
                    </button>
                    <CreateVideo ref="videoComponent"/>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import * as yup from "yup";
import { defineForm, field } from 'vue-yup-form';
import router from '@/router';
import CreateVideo from '@/views/CreateVideo.vue';


const code = ref()
const fileError = ref('')
const titleError = ref('')
const contentError = ref('')
const selectedFile = ref(null)
const videoComponent = ref(null)
const videoRecorded = ref(null)

const toDashboard = () => {
    router.push('/dashboard')
}

//watch the videoComponent to set the value of url
watch(
    () => videoComponent.value?.videoURL,
    (newURL) => {
        if (newURL) {
            videoRecorded.value = videoComponent.value?.videoFile
            console.log(videoRecorded.value)
        }
    }
)

const schema = defineForm({
    title: field("", yup.string().required('The title field is required')),
    content: field("", yup.string().required('The content field is required'))
})

const handleChange = (event) => {
    const file = event.target.files[0]
    selectedFile.value = file 
}

{
    axios.get('http://localhost:8000/api/dashboard',
        {
            headers: {
                Authorization: `${localStorage.getItem('token')}`
            }
        })
        .then(response => {
            code.value = response.data.code

            if (!(code.value === 200)) {
                router.push('/')
            }
        })
        .catch(error => console.log('error from create note'))
}

const storeNote = async () => {
    const formData = new FormData();
    formData.append('title', schema.title.$value)
    formData.append('content', schema.content.$value)
    formData.append('file', selectedFile.value)
    formData.append('recordedVideo', videoRecorded.value)
    

    try {
        const response = await axios.post('http://localhost:8000/api/create/note',
            formData,
            {
                headers: {
                    Authorization: `${localStorage.getItem('token')}`
                }
            }
        )

        console.log(response.data)
        //if (response.data.code !== 200) {
        //    router.push('/')
        //}
        
        router.push('/dashboard')
    } catch (error) {
        console.log(error);
        titleError.value = error.response.data.errors.title ? error.response.data.errors.title[0] : '';
        contentError.value = error.response.data.errors.content ? error.response.data.errors.content[0] : '';
        fileError.value = error.response.data.errors.file ? error.response.data.errors.file[0] : ''
    }
}
</script>

<style scoped>
ul {
    height: 100%;
    position: absolute;
    width: 100%;
    z-index: 999999;
    margin: 0;
}

.loader-circle {
    display: block;
    height: 14px;
    margin: 0 auto;
    top: 50%;
    left: 100%;
    transform: translateY(-50%);
    transform: translateX(-50%);
    position: absolute;
    width: 100%;
    padding: 0;

    li {
        display: block;
        float: left;
        width: 10px;
        height: 10px;
        line-height: 10px;
        padding: 0;
        position: relative;
        margin: 0 0 0 4px;
        background: #999;
        animation: preload 1s infinite;
        top: -50%;
        border-radius: 100%;

        &:nth-child(2) {
            animation-delay: .2s;
        }

        &:nth-child(3) {
            animation-delay: .4s;
        }
    }
}

@keyframes preload {
    0% {
        opacity: 1
    }

    50% {
        opacity: .4
    }

    100% {
        opacity: 1
    }
}
</style>
