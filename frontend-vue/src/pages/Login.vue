<script setup lang="ts">
import FormButton from "@/components/FormButton.vue";
import Input from "@/components/Input.vue";
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const is_loading = ref(false);

const handleLogin = async (e: Event) => {
    // обработка запроса входа
    is_loading.value = true;
    const form = e.currentTarget as HTMLFormElement;
    const data = new FormData(form);

    let response;
    try {
        response = await axios.post("/api/login", data);
    } catch (e) {
        alert("Произошла ошибка");
        is_loading.value = false;
        return;
    }

    if (response.status == 200) {
        router.push("/chat");
    }
    is_loading.value = false;
};

const choiceAnother = () => {
    // переход на страницу входа
    router.push("/register");
};
</script>

<template>
    <div class="form_container">
        <h1>Вход в профиль</h1>
        <h4>Получите доступ к своему аккаунту</h4>
        <form @submit.prevent="handleLogin" class="form">
            <Input
                label="Email"
                id="login_email"
                name="email"
                type="text"
                placeholder="example@mail.ru"
                required
            />
            <Input
                label="Пароль"
                id="login_password"
                name="password"
                type="password"
                placeholder="•••••••••"
                required
            />
            <FormButton type="submit" class="form-btn" :is_loading="is_loading"
                >Войти</FormButton
            >
            <div>
                Нету аккаунта?
                <span @click="choiceAnother" class="auth-another-choice"
                    >Зарегистрироваться</span
                >
            </div>
        </form>
    </div>
</template>
