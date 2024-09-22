import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/auth/Login.vue";
import SignUp from "../views/auth/SignUp.vue";
import Create from "../views/crud/Create.vue";
import Index from "../views/crud/Index.vue";
import Edit from "../views/crud/Edit.vue";
import { useUserStore } from "@/stores/user";

const isLoggedIn = () => {
  const store = useUserStore();
  return store.isLoggedIn;
};

const routes = [
  {
    path: "/",
    name: "Home",
    redirect: () => {
      if (isLoggedIn()) {
        return "/index";
      } else {
        return "/login";
      }
    },
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/signup",
    name: "SignUp",
    component: SignUp,
  },

  {
    name: "Create",
    path: "/create",
    component: Create,
    meta: { requiresAuth: true },
  },
  {
    name: "Index",
    path: "/index",
    component: Index,
    meta: { requiresAuth: true },
  },
  {
    name: "Edit",
    path: "/edit/:id",
    component: Edit,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to) => {
  // BLOCK LOGIN FOR LOGGED IN USERS
  if (to.name === "login" && isLoggedIn()) {
    return "/";
  }

  // REDIRECT TO LOGIN IF NOT LOGGED IN AND PAGE AUTH REQUIRED
  if (to.meta?.requiresAuth && !isLoggedIn()) {
    return "/login";
  }
});

export default router;
