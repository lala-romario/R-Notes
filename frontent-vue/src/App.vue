<template>
    

    <router-view></router-view>

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
