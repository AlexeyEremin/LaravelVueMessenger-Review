<script setup lang="ts">
import axios from "axios";
import { onMounted } from "vue";
import { configureEcho } from "@laravel/echo-vue";

configureEcho({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    authEndpoint: `${import.meta.env.VITE_BACKEND_URL}/broadcasting/auth`,

    // wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "ws"],
});

onMounted(async () => {
    await axios.get("/sanctum/csrf-cookie");
});
</script>

<template>
    <main>
        <RouterView />
    </main>
</template>

<style scoped>
header {
    height: 60px;
    width: 100%;
    color: #545454;
}
</style>
