<script setup lang="tsx">
import { useAttrs } from "vue";

interface InputProps {
    label?: string;
    id: string;
    styleType?: "md" | "lg";
}

const props = withDefaults(defineProps<InputProps>(), {
    styleType: "md",
});

const attrs = useAttrs();
</script>

<template>
    <div class="container_input">
        <label v-if="label" class="label" :for="props.id"
            >{{ props.label }}
        </label>
        <input class="input" :class="styleType" v-bind="attrs" :id="id" />
    </div>
</template>

<style lang="css" scoped>
.container_input {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.input {
    border-radius: 8px;
    padding-left: 12px;
    border: 2px solid var(--primary);
    outline: none;
}
.label {
    font-weight: 600;
}

.lg {
    height: 48px;
    width: 400px;
    font-size: 18px;
}
.md {
    height: 36px;
    width: 280px;
}
</style>
