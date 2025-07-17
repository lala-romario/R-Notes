<template>
    <form action="" class="mt-30">
        <div class="flex justify-center">
            <div class="p-10 bg-neutral-900 shadow-xl rounded">
                <div class="space-y-6 ">
                    <div>
                        <h1 class="text-3xl text-neutral-300">Create an account</h1>
                    </div>
                    <div>
                        <label for="name" class="text-neutral-200 text-2xl">Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name"
                                class="border-2 border-cyan-500 h-15 w-100 rounded text-neutral-200 text-xl pl-2">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="text-neutral-300 text-2xl">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email"
                                class="border border-white h-15 w-100 rounded text-neutral-200 text-xl pl-2 hover:outline-none">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="text-neutral-300 text-2xl">Password</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password"
                                class="border-2 border-blue-500 h-15 w-100 rounded text-white text-xl pl-2">
                        </div>
                    </div>
                </div>
                <button type="submit" class="mt-10 text-neutral-300 text-xl bg-cyan-500 shadow-lg shadow-cyan-500/50 p-2 rounded">Signup</button>
            </div>
        </div>
    </form>
</template>

<script setup>

</script>
