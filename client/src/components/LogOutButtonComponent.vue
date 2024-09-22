<template>
  <div class="d-flex justify-content-end p-1">
    <button @click="logout" class="btn btn-outline-danger">
      Logout
    </button>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user'; // Adjust the import path as needed

const router = useRouter();
const userStore = useUserStore();

const logout = () => {
  userStore.logout();
  router.push('/login');
};
</script>