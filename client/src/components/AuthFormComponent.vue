<template>
  <form @submit.prevent="onSubmit">
    <h2 class="fw-bold mb-2 text-uppercase text-center">{{ title }}</h2>
    <p class="text-black-50 mb-5 text-center">Please enter your information!</p>

    <div data-mdb-input-init class="form-outline mb-4">
      <input v-model="email" type="email" id="form2Example1" class="form-control" />
      <label class="form-label" for="form2Example1">Email address</label>

    </div>

    <div data-mdb-input-init class="form-outline mb-4">
      <input v-model="password" type="password" id="form2Example2" class="form-control" required />
      <label class="form-label" for="form2Example2">Password</label>
    </div>
    <div class="d-flex justify-content-center">
      <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">{{ title
        }}</button>
    </div>
    <div class="text-center">
      <p>Not a {{ title.toLowerCase() }}?
        <a :href="`/${title.toLowerCase() === 'login' ? 'signup' : 'login'}`">
          {{ title.toLowerCase() === 'Login' ? 'Register' : 'Sign in' }}
        </a>
      </p>
    </div>
  </form>
</template>

<script>
import { useUserStore } from '@/stores/user'

export default {
  props: {
    title: {
      type: String,
      default: 'Login'
    }
  },
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async onSubmit() {
      try {
        const store = useUserStore()
        await store.auth({ 'email': this.email, 'password': this.password }, this.title.toLowerCase());
        this.$router.push({ name: 'Home' })

      } catch (error) {
        console.error('Auth Error:', error)
      }
    }
  }
};
</script>