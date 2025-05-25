<template>
  <!-- <div class="login-page">
    <h1>Login</h1>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="username">Username:</label>
        <input v-model="form.username" id="username" type="text" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input v-model="form.password" id="password" type="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </div> -->
  <section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">
    <div class="lg:w-1/2 lg:block hidden">
      <div class="flex items-center flex-col h-full justify-center">
        <!-- <img src="/assets/images/auth/auth-img.png" alt="" /> -->
      </div>
    </div>
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
      <div class="lg:max-w-[464px] mx-auto w-full">
        <div>
          <h4 class="mb-3">Sign In</h4>
        </div>
        <form @submit.prevent="handleLogin">
          <div class="icon-field mb-4 relative">
            <span
              class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl"
            >
              <Icon name="mage:email"></Icon>
            </span>
            <input
              v-model="form.username"
              type="text"
              class="text-neutral-400 form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
              placeholder="Username"
            />
          </div>
          <div class="relative mb-5">
            <div class="icon-field">
              <span
                class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl"
              >
                <Icon name="solar:lock-password-outline"></Icon>
              </span>
              <input
                type="password"
                v-model="form.password"
                class="text-neutral-400 form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                id="your-password"
                placeholder="Password"
              />
            </div>
            <span
              class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light"
              data-toggle="#your-password"
              @click="togglePasswordVisibility('your-password', this)"
            ></span>
          </div>
          <div class="mt-7">
            <div class="flex justify-between gap-2">
            </div>
          </div>

          <fwb-button
            type="submit"
            class="btn btn-primary justify-center text-sm btn-sm px-3 py-4 w-full rounded-xl mt-8"
            :loading="isLoading"
          >
            Sign In
          </fwb-button>
        </form>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { FwbButton } from "flowbite-vue";
import { fetch } from "~/utils/fetchWrapper";

definePageMeta({
  layout: "auth",
});
const form = ref({
  username: "",
  password: "",
});
const isLoading = ref(false);

const errorMessage = ref(null);
const router = useRouter();

async function handleLogin() {
  isLoading.value = true;
  errorMessage.value = null;

  await fetch
    .post("http://localhost:8000/api/login", form.value)
    .then((response) => {
      isLoading.value = false;
      // const expiresIn = response.data.expires_in;
      // const expirationTime = Date.now() + expiresIn * 1000;

      sessionStorage.setItem("auth_token", response.accessToken);
      sessionStorage.setItem("jenis_pegawai", response.jenis_pegawai);
      // sessionStorage.setItem("token_expiration", expirationTime);

      if (sessionStorage.getItem("auth_token")) {
        // router.push("/dashboard");
        if(sessionStorage.getItem("jenis_pegawai") == "pendaftaran"){
          router.push("/modul/pendaftaran");
        } else if(sessionStorage.getItem("jenis_pegawai") == "dokter"){
          router.push("/modul/dokter");
        } else if(sessionStorage.getItem("jenis_pegawai") == "perawat"){
          router.push("/modul/perawat");
        } else if(sessionStorage.getItem("jenis_pegawai") == "apoteker"){
          router.push("/modul/apoteker");
        }
      }
    })
    .catch((error) => {
      isLoading.value = false;
      errorMessage.value = error.message || "Login failed";
    });
  }
function togglePasswordVisibility(inputId, toggleElement) {
  const input = document.getElementById(inputId);

  if (input.type === "password") {
    input.type = "text";
    toggleElement.classList.remove("ri-eye-line");
    toggleElement.classList.add("ri-eye-off-line");
  } else {
    input.type = "password";
    toggleElement.classList.remove("ri-eye-off-line");
    toggleElement.classList.add("ri-eye-line");
  }
}
</script>

<style scoped>
.login-page {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
}
.error {
  color: red;
}
</style>
