<template>

    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-cyan-200 font-semibold">R-Notes</h1>
            </div>

            <div class="flex justify-end pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex justify-end">
                    <div class="flex">
                        <a class="flex list-none space-x-10 lg:space-x-20">
                            <p><a @click="toCreateNote()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">
                                    Make your note better</a>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="mb-10">
        <div class=" flex justify-center mt-15 ">
            <div class="shadow-lg p-6 space-y-10 rounded bg-gray-100">
                <h1 class="text-neutral-600  text-3xl">Create a new note</h1>
                <div class="">
                    <label for="title" class="text-gray-600 text-2xl">Title</label>
                    <div>
                        <input type="text" name="title" id="title" v-model="schema.title.$value" placeholder="Title"
                            @focus="titleError = schema.title.$error.message"
                            class="w-140 mt-2 border border-neutral-800 rounded h-12 p-2">
                        <p v-if="schema.title.$error" class="mt-2 text-red-600">{{ titleError }}</p>
                    </div>
                </div>

                <div class="">
                    <label for="content" class="text-gray-600 text-2xl">Content</label>
                    <div>
                        <textarea name="content" id="content" placeholder="Type your text here"
                            v-model="schema.content.$value" @focus="contentError = schema.content.$error.message"
                            class="w-150 mt-2 border border-neutral-800 p-4 h-30 rounded"></textarea>
                        <p v-if="schema.content.$error" class="text-red-600">{{ contentError }}</p>
                    </div>
                </div>

                <!-- upload file section-->
                <div class="flex items-center justify-center w-full">
                    <label for="file"
                        class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer  hover:bg-neutral-50 hover:bg-gray-100 duration-500 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-neutral-300">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>

                            <p class="mb-2 text-sm dark:text-neutral-400"><span
                                    class="font-semibold text-neutral-400">Click
                                    to upload a file</span> or drag and drop</p>
                            <p class="text-neutral-500" v-if="selectedFile">{{ selectedFile.name }}</p>
                            <p class="text-xs text-red-500 dark:text-red-400" v-if="fileError">
                                {{ fileError }}
                            </p>
                        </div>
                        <input id="file" type="file" name="file" class="hidden" @change="handleChange" />
                    </label>
                </div>

                <!-- <div>
                        <ul class="loader-circle">
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                      </div> 
                    -->
                <div class="flex gap-70">
                    <div>
                        <button type="submit" @click.prevent="storeNote()"
                            class="text-white text-xl px-10 py-2 bg-teal-700 hover:bg-teal-800 shadow-lg duration-500 cursor-pointer rounded">Save</button>
                    </div>
                    <div class="ml-4">
                        <CreateVideo ref="videoComponent" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div v-if="videoComponent" >
        <p @change="haveURL()">its prise en charge {{ videoComponent.enabled }}, {{ url = videoComponent.videoURL }}</p>
    </div> -->
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import * as yup from "yup";
import { defineForm, field } from 'vue-yup-form';
import router from '@/router';
import CreateVideo from '@/views/CreateVideo.vue';


const fileError = ref('')
const titleError = ref('')
const contentError = ref('')
const selectedFile = ref(null)
const videoComponent = ref(null)
const videoRecorded = ref(null)


//watch the videoComponent to set the value of url
watch(
    () => videoComponent.value?.videoURL,
    (newURL) => {
        if (newURL) {
            videoRecorded.value = videoComponent.value?.videoFile
            //console.log(videoRecorded.value)
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

const storeNote = async () => {
    const formData = new FormData();
    formData.append('title', schema.title.$value)
    formData.append('content', schema.content.$value)
    formData.append('file', selectedFile.value)
    formData.append('recordedVideo', videoRecorded.value)
    console.log(videoRecorded)

    try {
        const response = await axios.post('http://localhost:8000/api/create/note', formData)
        console.log(response.data.filename)
        router.push('/dashboard')
    } catch (error) {
        console.log(error);
        titleError.value = error.response.data.errors.title ? error.response.data.errors.title[0] : '';
        contentError.value = error.response.data.errors.content ? error.response.data.errors.content[0] : '';
        fileError.value = error.response.data.errors.file ? error.response.data.errors.file[0] : ''
    }
}

const toCreateNote = () => {
    router.push('/create/note')
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
