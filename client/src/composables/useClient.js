import { ref } from "vue";
import api from "@/services/api";

export default function useClient() {
  const clients = ref([]);
  const client = ref({
    name: "",
    email: "",
    phone: "",
    address: "",
  });

  const fetchClients = async () => {
    try {
      const response = await api("/api/clients", { method: "GET" });
      clients.value = response;
    } catch (error) {
      console.error("Error fetching clients:", error);
      throw error;
    }
  };

  const fetchClient = async (id) => {
    try {
      const response = await api(`/api/clients/${id}`, { method: "GET" });
      client.value = response;
    } catch (error) {
      console.error("Error fetching client:", error);
      throw error;
    }
  };

  const createClient = async (clientData) => {
    try {
      const response = await api("/api/clients", {
        method: "POST",
        body: JSON.stringify(clientData),
      });
      clients.value.push(response);
      return response;
    } catch (error) {
      console.error("Error creating client:", error);
      throw error;
    }
  };

  const updateClient = async (id, clientData) => {
    try {
      const response = await api(`/api/clients/${id}`, {
        method: "PUT",
        body: JSON.stringify(clientData),
      });
      const index = clients.value.findIndex((c) => c.id === id);
      if (index !== -1) {
        clients.value[index] = response;
      }
      return response;
    } catch (error) {
      console.error("Error updating client:", error);
      throw error;
    }
  };

  const deleteClient = async (id) => {
    try {
      await api(`/api/clients/${id}`, { method: "DELETE" });
      clients.value = clients.value.filter((c) => c.id !== id);
    } catch (error) {
      console.error("Error deleting client:", error);
      throw error;
    }
  };

  return {
    clients,
    client,
    fetchClients,
    fetchClient,
    createClient,
    updateClient,
    deleteClient,
  };
}
