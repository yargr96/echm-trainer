import Vue from "vue"
import VueRouter from "vue-router"
import MathModule from "./components/MathModule"
import MathProto from "./components/MathProto"
import UsersAdministration from "./components/UsersAdministration"
import Login from "./components/Login"
import DBAdmin from "./components/DBAdministration"
import TrainingModule from "./components/Training"

Vue.use(VueRouter);

const routes = [
  /* {
    path: '/',
    redirect: '/auth'
  }, */
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
  {
    path: '/db-admin',
    component: DBAdmin
  },
  {
    path: '/training',
    component: TrainingModule
  },
];

export const router = new VueRouter({
  routes
})