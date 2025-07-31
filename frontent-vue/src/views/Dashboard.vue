<template>
    <header class="items-center w-full bg-teal-800 py-5 px-5">
        <nav class="flex">
            <div class="w-20">
                <h1 class="text-xl text-teal-500 font-semibold">R-Notes</h1>
            </div>

            <div class="flex justify-end pl-2 lg:ml-200 md:ml-100 sm:ml-10">
                <div class="flex justify-end">
                    <div class="flex">
                        <ul class="flex list-none space-x-10 lg:space-x-20">
                            <li><a @click="toCreateNote()"
                                    class="text-xl text-white hover:text-neutral-500 duration-500 cursor-pointer">Create note</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const toCreateNote = () => {
    router.push('/create/note');
}
</script>
