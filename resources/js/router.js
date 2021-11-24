import Vue from "vue"
import VueRouter from "vue-router"

// middlewares
import admin from "./middlewares/admin"
import editor from "./middlewares/editor"

// routes
const Login = () => import("./page/LoginComponent")
const Admin = () => import("./components/layouts/AdminComponent")
const Roles = () => import("./page/RolesComponent")
const Ueb = () => import("./page/UebComponent")
const Cultivo = () => import("./page/CultivosComponent")
const Ausencia = () => import("./page/AusenciasComponent")
const User = () => import("./page/UserComponent")
const Test = () => import("./page/Test")
const Quimicos = () => import("./page/QuimicosComponent")
const Valores = () => import("./page/ValoresComponent")
const Toneladas = () => import("./page/ToneladasComponent")
const NotFound = () => import("./page/NotFoundComponent")
const Energia = () => import("./page/EnergiaComponent")
const Maquinas = () => import("./page/MaquinasComponent")
const Siembra = () => import("./page/SiembraComponent")
const Principal = () => import("./page/PrincipalComponent")
const NoAutorizado = () => import("./page/NoAutorizadoComponent")

import NProgress from "nprogress/nprogress.js"
import "nprogress/nprogress.css"

Vue.use(VueRouter)

function verify(to, from, next) {
  axios
    .get("api/verify")
    .then((res) => next())
    .catch((err) => next("/login"))
}

const routes = [
  {
    path: "*",
    component: NotFound,
    name: "NotFound",
  },
  {
    path: "/",
    redirect: "/login",
  },
  {
    path: "/login",
    component: Login,
    name: "Login",
  },
  {
    path: "/403",
    name: "403",
    meta: { type: "403" },
    component: NoAutorizado,
  },
  {
    path: "/test",
    component: Test,
    name: "Test",
    beforeEnter: verify,
    // meta: { middleware: [editor] },
  },
  {
    path: "/admin",
    component: Admin,
    meta: { middleware: [admin] },
    redirect: "/admin/home",
    children: [
      {
        path: "home",
        component: Principal,
        name: "home",
      },
      {
        path: "users",
        component: User,
        name: "User",
      },
      {
        path: "roles",
        component: Roles,
        name: "Roles",
      },
      {
        path: "maquinas_riego",
        component: Maquinas,
        name: "Maquinas",
      },

      {
        path: "ueb",
        component: Ueb,
        name: "Ueb",
      },
      {
        path: "cultivos",
        component: Cultivo,
        name: "Cultivo",
      },
      {
        path: "ausencias",
        component: Ausencia,
        name: "Ausencia",
      },
      {
        path: "quimicos",
        component: Quimicos,
        name: "Quimicos",
      },
      {
        path: "diaria_acumuladas_por_valores",
        component: Valores,
        name: "Valores",
      },
      {
        path: "diaria_acumuladas_por_toneladas",
        component: Toneladas,
        name: "Toneladas",
      },
      {
        path: "energia_combustible",
        component: Energia,
        name: "Energia",
      },
      {
        path: "siembra",
        component: Siembra,
        name: "Siembra",
      },
    ],
    beforeEnter: verify,
  },
]

const router = new VueRouter({ mode: "history", routes })

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token") || null
  window.axios.defaults.headers["Authorization"] = "Bearer " + token
  next()
})

router.beforeResolve((to, from, next) => {
  if (to.path) {
    NProgress.start()
  }
  next()
})
NProgress.configure({ showSpinner: false })

router.afterEach(() => {
  NProgress.done()
})

router.beforeEach(async (to, from, next) => {
  let wasNextCalled = false
  let nextArgs = null
  function n(...args) {
    wasNextCalled = true
    nextArgs = args
  }

  const middleware = to.matched
    .map((route) => route.meta.middleware || [])
    .reduce((acc, curr) => [...acc, ...curr], [])
  for (let m of middleware) {
    await m(to, from, n)
    if (wasNextCalled) {
      return next(...nextArgs)
    }
  }

  next()
})

export default router
