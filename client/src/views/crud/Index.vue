<template>
  <div>
    <LogOutButtonComponent />
    <div class="container mt-5">
      <h1 class="mb-4">Clients</h1>
      <div v-if="successMessage" class="alert alert-success">
        {{ successMessage }}
      </div>
      <div class="d-flex justify-content-end mb-4">
        <router-link :to="{ name: 'Create' }" class="btn btn-success">
          <i class="bi bi-plus-lg"></i> Add New Client
        </router-link>
      </div>

      <div v-if="loading" class="text-center">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div v-else-if="clients.length === 0" class="text-center">
        <p>No clients found.</p>
      </div>

      <div v-else class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead class="table-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Phone</th>
              <th scope="col">Address</th>
              <th scope="col" class="actions-column">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in paginatedClients" :key="client.id">
              <td>{{ client.id }}</td>
              <td>{{ client.name }}</td>
              <td>{{ client.email }}</td>
              <td>{{ client.phone }}</td>
              <td>{{ client.address }}</td>
              <td>
                <router-link :to="{ name: 'Edit', params: { id: client.id } }"
                  class="btn btn-sm btn-outline-primary me-2">
                  <i class="bi bi-pencil-square me-1"></i> Edit
                </router-link>
                <button class="btn btn-sm btn-outline-danger" @click="openDeleteConfirmation(client.id)">
                  <i class="bi bi-trash me-1"></i> Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
            </li>
            <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: currentPage === page }">
              <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- Delete Confirmation Modal -->
      <div v-if="showModal" class="modal fade show" style="display: block;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Delete</h5>
              <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this client?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
              <button type="button" class="btn btn-danger" @click="confirmDelete">Delete</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { ref, computed, onMounted } from 'vue'
import useClient from '@/composables/useClient'
import LogOutButtonComponent from '@/components/LogOutButtonComponent.vue'

export default {
  components: { LogOutButtonComponent },
  setup() {
    const { clients, fetchClients, deleteClient } = useClient()
    const loading = ref(true)
    const currentPage = ref(1)
    const itemsPerPage = 10
    const successMessage = ref('')
    const showModal = ref(false)
    const clientIdToDelete = ref(null)

    const paginatedClients = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage
      const end = start + itemsPerPage
      return clients.value.slice(start, end)
    })

    const totalPages = computed(() => Math.ceil(clients.value.length / itemsPerPage))

    const fetchClientsData = async () => {
      loading.value = true
      try {
        await fetchClients()
      } catch (error) {
        console.error('Error fetching clients:', error)
      } finally {
        loading.value = false
      }
    }

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
      }
    }

    const openDeleteConfirmation = (id) => {
      clientIdToDelete.value = id
      showModal.value = true
    }

    const closeModal = () => {
      showModal.value = false
      clientIdToDelete.value = null
    }

    const confirmDelete = async () => {
      if (clientIdToDelete.value !== null) {
        try {
          await deleteClient(clientIdToDelete.value)
          successMessage.value = 'Client deleted successfully!'
          setTimeout(() => {
            successMessage.value = ''
          }, 3000)

          // Adjust current page if necessary
          if (paginatedClients.value.length === 0 && currentPage.value > 1) {
            currentPage.value--
          }
        } catch (error) {
          console.error('Error deleting client:', error)
        } finally {
          closeModal()
        }
      }
    }

    onMounted(fetchClientsData)

    return {
      clients,
      loading,
      currentPage,
      paginatedClients,
      totalPages,
      successMessage,
      showModal,
      changePage,
      openDeleteConfirmation,
      closeModal,
      confirmDelete
    }
  }
}
</script>

<style scoped>
.actions-column {
  width: 170px;
}
</style>