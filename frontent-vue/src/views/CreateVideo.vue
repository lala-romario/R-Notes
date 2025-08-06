<script setup lang="ts">
import { RefSymbol } from '@vue/reactivity'
import { useDevicesList, useUserMedia } from '@vueuse/core'
import { reactive, ref, shallowRef, watchEffect, defineExpose } from 'vue'

const currentCamera = shallowRef<string>()
const { videoInputs: cameras } = useDevicesList({
    requestPermissions: true,
    onUpdated() {
        if (!cameras.value.find(i => i.deviceId === currentCamera.value))
            currentCamera.value = cameras.value[0]?.deviceId
    },
})

const url = ref('')
const videoURL = ref('')
const videoFile = ref(null)

const recordedChunks = ref<Blob[]>([])
const video = ref<HTMLVideoElement | null>(null)
const { stream, enabled } = useUserMedia({
    constraints: reactive({ video: { deviceId: currentCamera }, audio: true }),
})

let mediaRecorder: MediaRecorder | null = null

watchEffect(() => {
    if (video.value)
        video.value.srcObject = stream.value!
    startRecording()
})

function startRecording() {
    recordedChunks.value = []

    if (stream.value) {
        mediaRecorder = new MediaRecorder(stream.value, {
            mimeType: 'video/webm;codecs=vp9' // ou 'video/webm'
        })

        mediaRecorder.ondataavailable = (event) => {
            if (event.data.size > 0) {
                recordedChunks.value.push(event.data)
            }
        }

        mediaRecorder.onstop = () => {
            const blob = new Blob(recordedChunks.value, { type: 'video/webm' })
            videoFile.value = new File([blob], 'video.webm', { type: 'video/webm' })
            videoURL.value = URL.createObjectURL(blob) //create a temporary link

            const a = document.createElement('a')
            a.href = videoURL.value
            console.log(videoURL.value)
            a.download = 'recorded-video.webm'
            a.target = '_blank'
            console.log(a)
            a.click()
        }

        mediaRecorder.start()
    }
}

function stopRecording() {
    mediaRecorder?.stop()
    console.log('stop recording')
}

if (enabled) {
    videoURL.value = ''
}

defineExpose({
    enabled,
    videoURL,
    videoFile
})
</script>

<template>
    <div class="flex flex-col gap-4 text-center">
        <div>
            <button @click="enabled = !enabled" @auxclick="stopRecording"
                class="text-white text-xl px-10 py-2 bg-teal-700 hover:bg-teal-800 shadow-lg duration-500 cursor-pointer rounded">
                {{ enabled ? 'Stop' : 'Start' }} camera
            </button>
        </div>

        <div>
            <div v-for="camera of cameras" :key="camera.deviceId" class="-mt-20 px-2 py-1 cursor-pointer"
                :class="{ 'text-primary': currentCamera === camera.deviceId }" @click="currentCamera = camera.deviceId"
                v-if="enabled">

            </div>
        </div>
        <div class="-mt-4">
            <video v-if="enabled" class="w-100" ref="video" controls autoplay muted />
        </div>
    </div>

    <a v-if="videoURL" :href="videoURL" download="recorded-video.webm" target="_blank"
        class="text-white text-xl px-10 py-2 bg-teal-700 hover:bg-teal-800 shadow-lg duration-500 cursor-pointer rounded">
        Download the video
    </a>

</template>
