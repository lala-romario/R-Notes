<template>

    <header class="items-center w-full border-b border-neutral-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-gray-400 font-semibold">R-Notes</h1>
            </div>

            <div class="flex justify-end pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex justify-end">
                    <div class="flex">
                        <a class="flex list-none space-x-10 lg:space-x-20">
                            <p><a @click="toCreateNote()"
                                    class="text-xl text-gray-400 hover:text-neutral-600 hover:shadow-lg duration-500 cursor-pointer">Create
                                    note</a>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <form method="post">
        <div class="flex justify-center mt-20 ">
            <div class="shadow-lg p-6 space-y-10 rounded bg-gray-100">
                <h1 class="text-neutral-500  text-3xl">Create a new note</h1>
                <div class="">
                    <label for="title" class="text-gray-500 text-2xl">Title</label>
                    <div>
                        <input type="text" name="title" id="title" v-model="form.title.$value" placeholder="Title"
                            class="w-140 mt-2 border border-neutral-800 rounded h-12 p-2">

                        <p v-if="form.title.$error" class="mt-2 text-red-600">{{ titleError }}</p>
                    </div>
                </div>

                <div class="">
                    <label for="content" class="text-gray-500 text-2xl">Content</label>
                    <div>
                        <textarea name="content" id="content" placeholder="Type your text here"
                            v-model="form.content.$value"
                            class="w-150 mt-2 border border-neutral-800 p-4 h-30 rounded"></textarea>
                        <p v-if="form.content.$error" class="text-red-600">{{ contentError }}</p>
                    </div>
                </div>

                <div>
                    <label for="image">Upload image</label>
                    <div>
                        <field type="file" name="image" />
                    </div>
                </div>

                <div>
                    <label for="video">Upload video</label>
                    <div>
                        <input type="file" name="video" id="video">
                    </div>
                </div>

                <!-- <div>
                <ul class="loader-circle">
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div> -->
                <button type="submit" @click.prevent="storeNote()"
                    class="text-white text-xl px-10 py-2 bg-blue-500 shadow-lg shadow-blue-500/50 rounded">Save</button>

                <button @click="startCam"
                    class="text-white text-xl ml-2 px-7 py-2 bg-blue-500 shadow-lg shadow-blue-500/50 rounded">start
                    camera</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import * as yup from "yup";
import Camera from "simple-vue-camera";
import { defineForm, field } from 'vue-yup-form';
import router from '@/router';

const route = useRouter();
const titleError = ref('');
const contentError = ref('');
const note = ref('');

const form = defineForm({
    title: field("", yup.string().required()),
    content: field("", yup.string().required()),
    image: field("", yup.file),
    video: field("", yup.file)
})

const storeNote = async () => {
    try {
        const response = await axios.post('http://localhost:8000/api/create/note', {
            title: form.title.$value,
            content: form.content.$value,
        })

        console.log(response.data.success)
        console.log(form.image);
        console.log(response.data.note);
    } catch (error) {
        console.log(error);
        titleError.value = error.response.data.errors.title[0];
        contentError.value = error.response.data.errors.content[0];
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
