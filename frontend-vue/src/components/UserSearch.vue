<script setup lang="tsx">
import { useAttrs } from "vue";
import IconCommunity from "./icons/IconCommunity.vue";
import { useRouter } from "vue-router";

const attrs = useAttrs();
const router = useRouter();
</script>

<template>
    <div
        @click="() => router.push('/search/users')"
        class="channel channel-icon"
        v-bind="attrs"
    >
        <IconCommunity />
    </div>
</template>

<style scoped></style>
