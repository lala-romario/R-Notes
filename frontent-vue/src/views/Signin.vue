<template>
    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <div class="w-auto animate-pulse mb-4 lg:mb-0">
                <h1 class="text-xl sm:text-2xl text-cyan-200 font-semibold">R-Notes</h1>
            </div>

            <!-- Menu -->
            <ul class="flex flex-wrap list-none space-x-4 mb-4 sm:space-x-8 lg:space-x-20">
                <li>
                    <a @click="toHome()"
                        class="text-lg sm:text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Home</a>
                </li>
                <li>
                    <button @click="toSignup()"
                        class="text-lg sm:text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Signup</button>
                </li>
                <li>
                    <a @click="toSignin()"
                        class="text-lg sm:text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Login</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="mt-10 p-5">
        <div class="flex justify-center">
            <div class="p-10 bg-gray-100 shadow-xl rounded">
                <div class="space-y-6 ">
                    <div>
                        <h1 class="text-2xl sm:text-3xl text-neutral-600">Log in to your account</h1>
                    </div>
                    <div>
                        <label for="email" class="text-gray-600 text-2xl">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" v-model="schema.email.$value"
                                @focus="emailError = schema.email.$error.message" placeholder="Email"
                                class="border border-neutral-800 rounded w-full h-12 p-2 rounded pl-2 ">
                        </div>>
                        <p v-if="schema.email.$error" class="text-red-500 mt-2">{{ emailError }}</p>
                    </div>
                    <div>
                        <label for="password" class="text-neutral-600 text-2xl">Password</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" v-model="schema.password.$value"
                                @focus="passwordError = schema.password.$error.message" placeholder="Password"
                                class="border border-neutral-800 rounded w-full h-12 p-2 rounded pl-2 ">
                        </div>
                        <p v-if="schema.password.$error" class="text-red-500 mt-2">{{ passwordError }}</p>
                    </div>
                </div>
                <p v-if="credentialsError" class="mt-2 text-red-500">{{ credentialsError }}</p>
                <button @click.prevent="signin()"
                    class="mt-4 text-white text-xl px-10 py-2 bg-teal-700 hover:bg-teal-800 shadow-lg duration-500 cursor-pointer rounded">Sign
                    in</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import * as yup from "yup";
import { useRouter } from 'vue-router'
import { defineForm, field } from 'vue-yup-form';
import axios from 'axios';


const credentialsError = ref('')
const emailError = ref('')
const passwordError = ref('')
const schema = defineForm({
    email: field("", yup.string().required('The email field is required')),
    password: field("", yup.string().required('The password is required').min(12))
});

const signin = async () => {
    const formData = new FormData()
    formData.append('email', schema.email.$value)
    formData.append('password', schema.password.$value)
    try {
        const response = await axios.post('http://localhost:8000/api/login', formData);
        console.log(response.data)
        if (response.data.code === 401) {
            credentialsError.value = response.data.error
        }

        if (response.data.code === 200) {
            localStorage.setItem('token', response.data.token)
            router.push('/dashboard')
        }
    } catch (error) {
        console.log(error)
        emailError.value = error.response.data.errors.email ? error.response.data.errors.email[0] : '';
        passwordError.value = error.response.data.errors.password ? error.response.data.errors.password[0] : '';

    }
}

const router = useRouter()
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
