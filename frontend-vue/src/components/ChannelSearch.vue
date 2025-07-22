<script setup lang="tsx">
import { useAttrs } from "vue";
import IconSearch from "./icons/IconSearch.vue";
import { useRouter } from "vue-router";

const attrs = useAttrs();
const router = useRouter();
</script>

<template>
    <div
        @click="() => router.push('/search/channels')"
        class="channel channel-icon"
        v-bind="attrs"
    >
        <IconSearch />
    </div>
</template>
