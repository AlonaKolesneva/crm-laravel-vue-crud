import { defineStore } from "pinia";
import api from "../../services/api";

export const useUserStore = defineStore("user", {
  state: () => ({
    loggedIn: false,
  }),
  getters: {
    isLoggedIn: (state) => {
      let loggedIn = window.localStorage.getItem("loggedIn");
      return loggedIn || state.loggedIn;
    },
    getToken: (state) => {
      return state.token;
    },
  },
  actions: {
    async auth(credentials, actionName = "login") {
      try {
        const link = "/api/" + (actionName === "login" ? "login" : "register");
        const response = await api(link, {
          method: "POST",
          body: JSON.stringify(credentials),
        });
        if (response.token) {
          this.loggedIn = true;
          window.localStorage.setItem("loggedIn", "true");
          window.localStorage.setItem("token", response.token);
        }
        return true;
      } catch (error) {
        console.error("Failed to fetch login:", error);
      }
    },
    async logout() {
      await api("/api/logout", { method: "POST" });
      this.loggedIn = false;
      window.localStorage.removeItem("loggedIn");
      window.localStorage.removeItem("token");
    },
  },
});
