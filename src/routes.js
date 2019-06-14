import Vue from "vue"
import VueRouter from "vue-router"
import MathModule from "./components/MathModule"
import MathProto from "./components/MathProto"
import UsersAdministration from "./components/UsersAdministration"
import Login from "./components/Login"

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    redirect: '/auth'
  },
  {
    path: '/math-module',
    component: MathModule
  },
  {
    path: '/math-proto',
    component: MathProto
  },
  {
    path: '/users-administration',
    component: UsersAdministration
  },
  {
    path: '/auth',
    component: Login
  },
];

export const router = new VueRouter({
  routes
})