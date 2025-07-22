<script setup lang="tsx">
const props = defineProps(["title", "is_active"]);
import { useAttrs } from "vue";

const attrs = useAttrs();
</script>

<template>
    <div class="channel" :class="{ active: is_active }" v-bind="attrs">
        <div class="title">{{ props.title }}</div>
    </div>
</template>

<style scoped>
.active {
    background-color: var(--primary);
    color: white;
}
</style>
