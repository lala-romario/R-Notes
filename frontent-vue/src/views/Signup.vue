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

    <div class="mt-10 sm:mt-20 p-5">
        <div class="flex justify-center">
            <div class="w-full max-w-md p-6 sm:p-10 bg-gray-100 shadow-xl rounded">

                <h1 class="text-2xl sm:text-3xl text-neutral-600 mb-6">Create an account</h1>

                <div class="space-y-6">

                    <!-- Name -->
                    <div>
                        <label for="name" class="text-gray-600 text-lg sm:text-2xl">Name</label>
                        <input type="text" id="name" v-model="schema.name.$value"
                            @focus="nameError = schema.name.$error.message" placeholder="Name"
                            class="mt-2 border border-neutral-800 rounded w-full h-12 px-2">
                        <p v-if="schema.name.$error" class="text-red-500 mt-2">{{ nameError }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="text-gray-600 text-lg sm:text-2xl">Email</label>
                        <input type="email" id="email" v-model="schema.email.$value"
                            @focus="emailError = schema.email.$error.message" placeholder="Email"
                            class="mt-2 border border-neutral-800 rounded w-full h-12 px-2">
                        <p v-if="schema.email.$error" class="text-red-500 mt-2">{{ emailError }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="text-neutral-600 text-lg sm:text-2xl">Password</label>
                        <input type="password" id="password" v-model="schema.password.$value"
                            @focus="passwordError = schema.password.$error.message" placeholder="Password"
                            class="mt-2 border border-neutral-800 rounded w-full h-12 px-2">
                        <p v-if="schema.password.$error" class="text-red-500 mt-2">{{ passwordError }}</p>
                        <p v-else class="text-red-500 mt-2">{{ showPasswordError }}</p>
                    </div>

                </div>

                <!-- Bouton -->
                <button @click.prevent="sendForm"
                    class="mt-6 w-full text-white text-lg sm:text-xl py-3 bg-teal-700 hover:bg-teal-800 shadow-lg duration-500 cursor-pointer rounded">
                    Signup
                </button>

            </div>
        </div>
    </div>


    <p>{{ device }}</p>
    <p>{{ token }}</p>
</template>

<script setup>
import axios from 'axios';
import { ref, shallowReactive } from 'vue';
import * as yup from "yup";
import { useRouter } from 'vue-router'
import { defineForm, field } from 'vue-yup-form';


const token = ref('')
const device = ref('')
const nameError = ref('')
const emailError = ref('')
const passwordError = ref('')
const showPasswordError = ref('')
const schema = defineForm({
    name: field("", yup.string().required('The name field is required')),
    email: field("", yup.string().required('The email field is required').email('The email must be valid')),
    password: field("", yup.string().required('The password field is required'))
});

const sendForm = async () => {
    const formData = new FormData()
    formData.append('name', schema.name.$value)
    formData.append('email', schema.email.$value)
    formData.append('password', schema.password.$value)

    try {
        const response = await axios.post('http://localhost:8000/api/signup', formData);
        console.log(response.data)
        device.value = response.data.device
        localStorage.setItem('token', response.data.token)
        token.value = localStorage.getItem('token')
        router.push('/dashboard')
    } catch (error) {
        console.log(error)
        nameError.value = error.response.data.errors.name ? error.response.data.errors.name[0] : '';
        emailError.value = error.response.data.errors.email ? error.response.data.errors.email[0] : '';
        passwordError.value = error.response.data.errors.password ? error.response.data.errors.password[0] : '';
        showPasswordError.value = error.response.data.errors.password ? error.response.data.errors.password[0] : ''

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
