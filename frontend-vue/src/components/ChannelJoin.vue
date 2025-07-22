<script setup lang="tsx">
const props = defineProps(["title", "is_active"]);
import { useAttrs } from "vue";
import IconJoin from "./icons/IconJoin.vue";

const attrs = useAttrs();
</script>

<template>
    <div class="channel" :class="{ active: is_active }" v-bind="attrs">
        <div class="title">{{ props.title }}</div>
        <button class="channel-join" :class="{ active: is_active }">
            <IconJoin />
        </button>
    </div>
</template>

<style scoped>
.active {
    background-color: var(--primary);
    color: white;
}
.channel-join {
    border: none;
    background-color: none;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: auto;
}
</style>
