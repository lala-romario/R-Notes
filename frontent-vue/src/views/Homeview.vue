<template>

    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-gray-400 font-semibold">R-Notes</h1>
            </div>

            <div class="flex justify-end pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex justify-end">
                    <div class="flex">
                        <ul class="flex list-none space-x-10 lg:space-x-20">
                            <li><a @click="toHome()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Home</a>
                            </li>
                            <li><button @click="toSignup()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Signup</button>
                            </li>
                            <li><a @click="toSignin()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Signin</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="flex justify-center mt-60">
        <div class="">
            <h2 class="text-6xl text-neutral-900">The build tool</h2>
            <h2 class="text-5xl text-center text-neutral-600">to take a note</h2>
        </div>
    </div>


</template>

<script setup>
import { useRouter } from 'vue-router'
import { ref } from 'vue'


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
