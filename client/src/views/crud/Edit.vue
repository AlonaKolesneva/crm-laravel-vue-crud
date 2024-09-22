<template>
  <div>
    <LogOutButtonComponent />
    <div class="container mt-5">
      <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
          <h1 class="card-title text-center">Edit Client</h1>
        </div>
        <div class="card-body">
          <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
          </div>
          <div v-if="loading" class="text-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <ClientFormComponent v-else :client="client" submit-button-text="Update Client"
            @submit="handleUpdateClient" />
          <div class="mt-4 d-flex justify-content-start">
            <router-link :to="{ name: 'Index' }" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left-circle"></i> Return to Clients List
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import ClientFormComponent from '@/components/ClientFormComponent.vue'
import LogOutButtonComponent from '@/components/LogOutButtonComponent.vue'
import useClient from '@/composables/useClient'

export default {
  components: {
    ClientFormComponent,
    LogOutButtonComponent
  },
  setup() {
    const route = useRoute()
    const router = useRouter()
    const { client, fetchClient, updateClient } = useClient()
    const successMessage = ref('')
    const loading = ref(true)

    const fetchClientData = async () => {
      try {
        await fetchClient(route.params.id)
      } catch (error) {
        console.error('Error fetching client:', error)
      } finally {
        loading.value = false
      }
    }

    const handleUpdateClient = async (updatedClient) => {
      try {
        await updateClient(route.params.id, updatedClient)
        successMessage.value = 'Client Updated Successfully!'
        setTimeout(() => {
          successMessage.value = ''
          router.push({ name: 'Index' })
        }, 2000)
      } catch (error) {
        console.error('Error updating client:', error)
      }
    }

    onMounted(fetchClientData)

    return {
      client,
      loading,
      successMessage,
      handleUpdateClient
    }
  }
}
</script>

<style scoped>
.bg-gradient-primary {
  background: linear-gradient(45deg, #007bff, #6610f2);
}
</style>