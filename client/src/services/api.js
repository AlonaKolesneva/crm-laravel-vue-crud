import { useUserStore } from '@/stores/user'
const baseURL = "http://127.0.0.1:8000";

const api = async (url, options = {}) => {
  const token = localStorage.getItem("token");
  const headers = {
    "Content-Type": "application/json",
    ...options.headers,
  };

  // Add Authorization header if token exists
  if (token) {
    headers["Authorization"] = "Bearer " + token;
  }

  // Final fetch options
  const config = {
    ...options,
    headers,
    // credentials: 'include'
  };

  try {
    const response = await fetch(baseURL + url, config);

    // Check for 403 Forbidden or 401 Unauthorized status and handle it
    //token expired
    if (
      (response.status === 401 &&
        response.message !== "Invalid login details") ||
      response.status === 403
    ) {
      const store = useUserStore()
      await store.logout();
    }
    return response.json();
  } catch (error) {
    console.error("API request failed:", error.message);
    throw error;
  }
};

export default api;
