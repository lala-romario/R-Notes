<template>
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

const icons = [
    { lable: 'Github', icon: 'github' },
    { lable: 'linkedin', icon: '' }
]

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
