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
const User = () => import("./page/admin/UserComponent")
const Test = () => import("./page/Test")
const NotFound = () => import("./page/NotFoundComponent")

const Principal = () => import("./page/admin/PrincipalComponent")
const NoAutorizado = () => import("./page/NoAutorizadoComponent")

// rol editor
const HomeEditor = () => import("./page/editor/HomeComponent");
const Editor = () => import("./components/layouts/EditorComponent");
const Energia = () => import("./page/editor/EnergiaComponent");
const Maquinas = () => import("./page/editor/MaquinasComponent");
const Siembra = () => import("./page/editor/SiembraComponent");
const Quimicos = () => import("./page/editor/QuimicosComponent");
const Valores = () => import("./page/editor/ValoresComponent");
const Toneladas = () => import("./page/editor/ToneladasComponent");
const Productos = () => import("./page/editor/CultivosComponent");
const Ausencia = () => import("./page/editor/AusenciasComponent");
const Cosechas = () => import("./page/editor/CosechasComponent");
const Culturales = () => import('./page/editor/CulturalesComponent.vue');
const Tierra = () => import('./page/editor/TierraComponent.vue');
const General = () => import('./page/editor/GeneralComponent.vue');
const Diario = () => import('./page/editor/DiarioComponent.vue');

// rol editor // incidencias
const IncidenciaSiembra = () => import('./page/editor/Incidencias/IncidenciasSiembraComponent');
const IncidenciaMaquinas = () => import('./page/editor/Incidencias/IncidenciasMaquinaComponent');
const IncidenciaQuimicos = () => import('./page/editor/Incidencias/IncidenciasQuimicosComponent');
const IncidenciaAusencia = () => import('./page/editor/Incidencias/IncidenciasAusenciaComponent');
const IncidenciaValore = () => import('./page/editor/Incidencias/IncidenciasValoreComponent');
const IncidenciaTonelada = () => import('./page/editor/Incidencias/IncidenciasToneladaComponent');
const IncidenciaEnergia = () => import('./page/editor/Incidencias/IncidenciasEnergiaComponent');
const IncidenciaCosecha= () => import('./page/editor/Incidencias/IncidenciasCosechaComponent');
const IncidenciaCulturale= () => import('./page/editor/Incidencias/IncidenciasCulturaleComponent');
const IncidenciaTierra= () => import('./page/editor/Incidencias/IncidenciasTierraComponent');

// rol usuario ueb
const UsuarioUeb = () => import("./components/layouts/UsuarioUebComponent")

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
  },

  // admin
  {
    path: "/admin",
    component: Admin,
    beforeEnter: verify,
    redirect: "/admin/inicio",
    children: [
      {
        path: "inicio",
        component: Principal,
        name: "inicio",
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
    meta: { middleware: [admin] },
  },

  // editor 
  {
    path: '/editor',
    component: Editor,
    meta: { middleware: [editor] },
    name: 'Editor',
    redirect: "/editor/inicio",
    children: [
      {
        path: 'inicio',
        component: HomeEditor,
        name: 'home'
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
        path: "cosechas",
        component: Cosechas,
        name: "Cosecha",
      },
      {
        path: "siembra",
        component: Siembra,
        name: "Siembra",
      },
      {
        path: "culturales",
        component: Culturales,
        name: "Culturales",
      },
      {
        path: "tierra",
        component: Tierra,
        name: "Tierra",
      },
      {
        path: "general",
        component: General,
        name: "General",
      },
      {
        path: 'diario',
        component: Diario,
        name: 'Diario'
      },
      // incidencias
      {
        path: "incidencias_siembra",
        component: IncidenciaSiembra,
        name: 'Incidencia Siembra'
      },
      {
        path: "incidencias_maquina",
        component: IncidenciaMaquinas,
        name: 'Incidencia Maquinas'
      },
      {
        path: "incidencias_quimicos",
        component: IncidenciaQuimicos,
        name: 'Incidencia Quimicos'
      },
      {
        path: "incidencias_ausencia",
        component: IncidenciaAusencia,
        name: 'Incidencia Ausencia'
      },
      {
        path: "incidencias_valores",
        component: IncidenciaValore,
        name: 'Incidencia Valore'
      },
      {
        path: "incidencias_tonelada",
        component: IncidenciaTonelada,
        name: 'Incidencia Tonelada'
      },
      {
        path: "incidencias_energia",
        component: IncidenciaEnergia,
        name: 'Incidencia Energia'
      },
      {
        path: "incidencias_cosecha",
        component: IncidenciaCosecha,
        name: 'Incidencia Cosecha'
      },
      {
        path: "incidencias_culturale",
        component: IncidenciaCulturale,
        name: 'Incidencia Culturale'
      },
      {
        path: "incidencias_tierra",
        component: IncidenciaTierra,
        name: 'Incidencia Tierra'
      },
    ],
    beforeEnter: verify,
  },
  
  // usuario ueb
  {
    path: '/usuario_ueb',
    component: UsuarioUeb,
    name: 'UsuarioUeb',
    beforeEnter: verify,
    meta: { middleware: [usuario_ueb] },
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
      {
        path: "cosechas",
        component: Cosechas,
        name: "Cosechas",
      },
      {
        path: "culturales",
        component: Culturales,
        name: "Culturale",
      },
       {
        path: "tierra",
        component: Tierra,
        name: "Tierras",
      },
      
      {
        path: 'diario',
        component: Diario,
        name: 'Diarios'
      }
    ],
    
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
