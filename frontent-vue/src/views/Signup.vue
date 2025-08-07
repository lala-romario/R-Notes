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
                            <li><a @click="toHome()"
                                    class="text-xl text-white hover:text-neutral-600 duration-500 cursor-pointer">Home</a>
                            </li>
                            <li><button @click="toSignup()"
                                    class="text-xl text-white hover:text-neutral-600 duration-500 cursor-pointer">Signup</button>
                            </li>
                            <li><a @click="toSignin()"
                                    class="text-xl text-white hover:text-neutral-600 duration-500 cursor-pointer">Signin</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="mt-30">
        <div class="flex justify-center">
            <div class="p-10 bg-gray-100 shadow-xl rounded">
                <div class="space-y-6 ">
                    <div>
                        <h1 class="text-3xl text-neutral-600">Create an account</h1>
                    </div>
                    <div>
                        <label for="name" class="text-gray-600 text-2xl">Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" v-model="schema.name.$value"
                                @focus="nameError = schema.name.$error.message" placeholder="Name"
                                class="border border-neutral-800 rounded w-100 h-12 rounded pl-2 ">
                        </div>
                        <p v-if="schema.name.$error" class="text-red-500 mt-2">{{ nameError }}</p>
                    </div>
                    <div>
                        <label for="email" class="text-gray-600 text-2xl">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" v-model="schema.email.$value"
                                @focus="emailError = schema.email.$error.message" placeholder="Email"
                                class="border border-neutral-800 rounded w-full h-12 p-2 rounded pl-2 ">
                        </div>
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
                        <p v-else class="text-red-500 mt-2">{{ showPasswordError }}</p>
                    </div>
                </div>
                <button @click.prevent="sendForm"
                    class="mt-4 text-white text-xl px-10 py-2 bg-teal-700 hover:bg-teal-800 shadow-lg duration-500 cursor-pointer rounded">Signup</button>
            </div>
        </div>
    </div>

    <p>{{ device }}</p>
</template>

<script setup>
import axios from 'axios';
import { ref, shallowReactive } from 'vue';
import * as yup from "yup";
import { useRouter } from 'vue-router'
import { defineForm, field } from 'vue-yup-form';


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
