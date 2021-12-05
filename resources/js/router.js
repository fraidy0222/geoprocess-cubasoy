import Vue from "vue"
import VueRouter from "vue-router"

// middlewares
import admin from "./middlewares/admin"
import editor from "./middlewares/editor"
import usuario_ueb from './middlewares/usuario_ueb';

// routes
const Login = () => import("./page/LoginComponent")
const Admin = () => import("./components/layouts/AdminComponent")
const Roles = () => import("./page/admin/RolesComponent")
const Ueb = () => import("./page/editor/UebComponent")
const Productos = () => import("./page/editor/CultivosComponent")
const Ausencia = () => import("./page/editor/AusenciasComponent")
const User = () => import("./page/admin/UserComponent")
const Test = () => import("./page/Test")
const Quimicos = () => import("./page/editor/QuimicosComponent")
const Valores = () => import("./page/editor/ValoresComponent")
const Toneladas = () => import("./page/editor/ToneladasComponent")
const NotFound = () => import("./page/NotFoundComponent")
const Energia = () => import("./page/editor/EnergiaComponent")
const Maquinas = () => import("./page/editor/MaquinasComponent")
const Siembra = () => import("./page/editor/SiembraComponent")
const Principal = () => import("./page/admin/PrincipalComponent")
const NoAutorizado = () => import("./page/NoAutorizadoComponent")

// rol editor
const Editor = () => import("./components/layouts/EditorComponent");
const IncidenciaSiembra = () => import('./page/editor/IncidenciasSiembraComponent');

// rol usuario ueb
const UsuarioUeb = () => import("./components/layouts/UsuarioUebComponent")
const General = () => import("./page/usuario_ueb/ReporteGeneralComponent")

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

  // admin
  {
    path: "/admin",
    component: Admin,
    // meta: { middleware: [admin] },
    redirect: "/admin/home",
    children: [
      {
        path: "home",
        component: Principal,
        name: "home",
      },
      {
        path: "usuarios",
        component: User,
        name: "User",
      },
      {
        path: "roles",
        component: Roles,
        name: "Roles",
      },
    ],
    beforeEnter: verify,
  },

  // editor 
  {
    path: '/editor',
    component: Editor,
    // meta: { middleware: [editor] },
    name: 'Editor',
    // redirect: "/editor/home",
    children: [
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
        path: "productos",
        component: Productos,
        name: "Productos",
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
      // incidencias
      {
        path: "incidencias_siembra",
        component: IncidenciaSiembra,
        name: 'Incidencia Siembra'
      }
    ],
    beforeEnter: verify,
  },
  
  // usuario ueb
  {
    path: '/usuario_ueb',
    component: UsuarioUeb,
    name: 'UsuarioUeb',
    // meta: { middleware: [usuario_ueb] },
    children: [
      {
        path: "maquinas_riego",
        component: Maquinas,
        name: "Generar Maquinas",
      },
      {
        path: "ausencias",
        component: Ausencia,
        name: "Generar Ausencia",
      },
      {
        path: "quimicos",
        component: Quimicos,
        name: "Generar Quimicos",
      },
      {
        path: "diaria_acumuladas_por_valores",
        component: Valores,
        name: "Generar Valores",
      },
      {
        path: "diaria_acumuladas_por_toneladas",
        component: Toneladas,
        name: "Generar Toneladas",
      },
      {
        path: "energia_combustible",
        component: Energia,
        name: "Generar Energia",
      },
      {
        path: "siembra",
        component: Siembra,
        name: "Generar Incidencia Siembra",
      },
    ],
    beforeEnter: verify,
  }
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
