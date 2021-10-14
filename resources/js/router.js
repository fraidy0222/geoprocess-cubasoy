import Vue from 'vue';
import VueRouter from 'vue-router';

// routes
const Login = () => import('./page/LoginComponent');
const Admin = () => import('./components/layouts/AdminComponent');
const Roles = () => import('./page/RolesComponent');
const Ueb = () => import('./page/UebComponent');
const Cultivo = () => import('./page/CultivosComponent');
const Ausencia = () => import('./page/AusenciasComponent');
const User = () => import('./page/UserComponent');
const Test = () => import('./page/Test');
const Quimicos = () => import('./page/QuimicosComponent');
const Valores = () => import('./page/ValoresComponent');
const NotFound = () => import('./page/NotFoundComponent');
const Energia = () => import('./page/EnergiaComponent');
const Maquinas = () => import('./page/MaquinasComponent');

import NProgress from 'nprogress/nprogress.js';
import 'nprogress/nprogress.css';
import store from './store';

import { AclInstaller, AclCreate, AclRule } from 'vue-acl';

Vue.use(VueRouter)

// export default new AclCreate({
//   initial: 'public',
//   notfound: {
//     path: '/error',
//     forwardQueryParams: true,
//   },
//   router,
//   acceptLocalRules: true,
//   globalRules: {
//     isAdmin: new AclRule('admin').generate(),
//     isPublic: new AclRule('public').or('admin').generate(),
//     isLogged: new AclRule('user').and('inside').generate()
//   },
//   middleware: async acl => {
//     await timeout(2000) // call your api
//     acl.change('admin')
//   }
// })

function verify(to, from, next) {
  axios.get('api/verify')
  .then(res => next())
  .catch(err => next('/login'))
}

const routes = [
  {
    path: '*',
    component: NotFound,
    name: 'NotFound',
  },
  {
    path: '/',
    redirect: '/login',
  },
  {
    path: '/login',
    component: Login,
    name: 'Login',
  },
  {
    path: '/test',
    component: Test,
    name: 'Test',
    meta: {
      adminAuth: false,
      rule: 'isPublic'
    },
    beforeEnter: verify,
  },   
  {
    path: '/admin',
    component: Admin,
    children: [
      {
        path: '/users',
        component: User,
        name: 'User',
        // beforeEnter: (to, from, next) => {
        //   if(store.getters["Admin"]) next();
        //   else next('/');
        // }
      },
      {
        path: '/roles',
        component: Roles,
        name: 'Roles',
      },
      {
        path: '/maquinas_riego',
        component: Maquinas,
        name: 'Maquinas',
      },
     
      {
        path: '/ueb',
        component: Ueb,
        name: 'Ueb',
        
      },
      {
        path: '/cultivos',
        component: Cultivo,
        name: 'Cultivo',
        
      },
      {
        path: '/ausencias',
        component: Ausencia,
        name: 'Ausencia',
        
      },
      {
        path: '/quimicos',
        component: Quimicos,
        name: 'Quimicos',
        
      },
      {
        path: '/valores',
        component: Valores,
        name: 'Valores',
        
      },
      {
        path: '/energia_combustible',
        component: Energia,
        name: 'Energia', 
      }
    ],
    meta: {
      requiresAuth: true,
      rule: new AclRule('admin').generate()
    }, 
    beforeEnter: verify,
  },
]

Vue.config.productionTip = false;

const router = new VueRouter({mode: 'history', routes })

router.beforeEach(( to, from, next ) => {
  const token = localStorage.getItem('token') || null
  window.axios.defaults.headers['Authorization'] = "Bearer " + token;
  next()
})

router.beforeResolve((to, from, next) => {
  if(to.path) {
    NProgress.start()
  }
  next()
})

router.afterEach(() => {
  NProgress.done()
})

router.beforeEach((to, from, next) => {
  if(store.getters["Admin"]) next();
  else next('/');
})
export default router
