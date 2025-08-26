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

    <div class="flex justify-center mt-60 ">
        <div class="text-animation">
            <h2 class="text-3xl sm:text-5xl lg:text-6xl text-neutral-900 animate-slideFromRight"
                style="animation-delay: 0.00000001s">The build
                tool</h2>
            <h2
                class="animate-typing  text-2xl sm:text-4xl lg:text-5xl text-center text-neutral-600 animate-slideFromLeft ">
                to take a
                note</h2>
        </div>
    </div>

    <div class="flex justify-center align-center">

        <button
            class="mt-20 px-4 py-2 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 bg-white transition-transform duration-300 ease-in-out hover:bg-purple-600 hover:border-transparent hover:text-white focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
            <div class="text-animation">
                <span>M</span>
                <span>e</span>
                <span>s</span>
                <span>s</span>
                <span>a</span>
                <span>g</span>
                <span>e</span>
            </div>
        </button>
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

<style scoped>
.animate-slideFromRight {
    animation: slideFromRight 0.8s ease-out forwards;
}

@keyframes slideFromRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-slideFromLeft {
    animation: slideFromLeft 0.8s ease-out forwards;
}

@keyframes slideFromLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }

    to {
        opacity: 1;
        transform: translateX(0px);
    }
}
</style>
