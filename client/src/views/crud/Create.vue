<template>
    <div>
        <LogOutButtonComponent />
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h1 class="card-title text-center">Create New Client</h1>
                </div>
                <div class="card-body">
                    <div v-if="successMessage" class="alert alert-success">
                        {{ successMessage }}
                    </div>
                    <ClientFormComponent :client="newClient" submit-button-text="Create Client"
                        @submit="handleCreateClient" />
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
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import ClientFormComponent from '@/components/ClientFormComponent.vue'
import useClient from '@/composables/useClient'
import LogOutButtonComponent from '@/components/LogOutButtonComponent.vue'

export default {
    components: {
        ClientFormComponent,
        LogOutButtonComponent
    },
    setup() {
        const router = useRouter()
        const { createClient } = useClient()
        const successMessage = ref('')
        const newClient = ref({
            name: '',
            email: '',
            phone: '',
            address: ''
        })

        const handleCreateClient = async (clientData) => {
            try {
                await createClient(clientData)
                successMessage.value = 'Client Created Successfully!'
                setTimeout(() => {
                    successMessage.value = ''
                    router.push({ name: 'Index' })
                }, 2000)
            } catch (error) {
                console.error('Error creating client:', error)
            }
        }

        return {
            newClient,
            successMessage,
            handleCreateClient
        }
    }
}
</script>

<style scoped>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #6610f2);
}
</style>