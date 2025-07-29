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
                            <li><a @click="toCreateNote()"
                                    class="text-xl text-gray-400 hover:text-neutral-600 hover:shadow-lg duration-500 cursor-pointer">Create note</a>
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
