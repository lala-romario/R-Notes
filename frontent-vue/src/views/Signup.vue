<template>

    <header class="items-center w-full border-b border-neutral-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-gray-400 font-semibold">R-Notes</h1>
            </div>

            <div class="flex justify-end pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex justify-end">
                    <div class="flex">
                        <ul class="flex list-none space-x-10 lg:space-x-20">
                            <li><a @click="toHome()"
                                    class="text-xl text-gray-400 hover:text-neutral-600 hover:shadow-lg duration-500 cursor-pointer">Home</a>
                            </li>
                            <li><button @click="toSignup()"
                                    class="text-xl text-gray-400 hover:text-neutral-600 hover:shadow-lg duration-500 cursor-pointer">Signup</button>
                            </li>
                            <li><a @click="toSignin()"
                                    class="text-xl text-gray-400 hover:text-neutral-600 hover:shadow-lg duration-500 cursor-pointer">Signin</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="mt-30">
        <div class="flex justify-center">
            <div class="p-10 bg-neutral-900 shadow-xl rounded">
                <div class="space-y-6 ">
                    <div>
                        <h1 class="text-3xl text-neutral-300">Create an account</h1>
                    </div>
                    <div>
                        <label for="name" class="text-neutral-200 text-2xl">Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" v-model="form.name.$value"
                                class="border-2 border-cyan-500 h-15 w-100 rounded text-neutral-200 text-xl pl-2">
                        </div>
                        <span v-if="form.name.$error" class="text-red-700 mt-5">{{ form.name.$error.message }}</span>
                    </div>
                    <div>
                        <label for="email" class="text-neutral-300 text-2xl">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" v-model="form.email.$value"
                                class="border border-white h-15 w-100 rounded text-neutral-200 text-xl pl-2 hover:outline-none">
                        </div>
                        <span v-if="form.email.$error" class="text-red-700">{{ form.email.$error.message }}</span>
                    </div>
                    <div>
                        <label for="password" class="text-neutral-300 text-2xl">Password</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" v-model="form.password.$value"
                                class="border-2 border-blue-500 h-15 w-100 rounded text-white text-xl pl-2">
                        </div>
                        <span v-if="form.password.$error" class="text-red-700 mt-5">{{ form.password.$error.message
                        }}</span>
                    </div>
                </div>
                <button @click.prevent="sendForm"
                    class="mt-10 text-neutral-300 text-xl bg-cyan-500 shadow-lg shadow-cyan-500/50 p-2 rounded">Signup</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import * as yup from "yup";
import { useRouter } from 'vue-router'
import { defineForm, field } from 'vue-yup-form';


const message = ref('')
const form = defineForm({
    name: field("", yup.string().required()),
    email: field("", yup.string().required()),
    password: field("", yup.string().required().min(12))
});

const sendForm = async () => {
    try {
        const response = await axios.post('http://localhost:8000/api/create', {
            name: form.name.$value,
            email: form.email.$value,
            password: form.password.$value
        });

        message.value = response.data.message
        console.log(message)
    } catch ($error) {
        console.log('error: ', $error)
    }
}

const router = useRouter();
const toHome = () => {
    router.push('/')
}
const toSignup = () => {
    router.push('/signup')
}
const toSignin = () => {
    router.push('/signin')
}

</script>
