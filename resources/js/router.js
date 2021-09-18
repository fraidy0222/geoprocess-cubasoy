import Vue from 'vue';
import VueRouter from 'vue-router';

// routes
import Login from './page/LoginComponent';
import Admin from './components/layouts/AdminComponent';
import Roles from './page/RolesComponent';
import Ueb from './page/UebComponent';
import Cultivo from './page/CultivosComponent';
import Ausencia from './page/AusenciasComponent';
import User from './page/UserComponent';
import Test from './page/Test';
import Quimicos from './page/QuimicosComponent';
import Valores from './page/ValoresComponent'
import NotFound from './page/NotFoundComponent';

Vue.use(VueRouter)

function verify(to, from, next) {
  axios.get('api/verify')
  .then(res => next())
  .catch(err => next('/login'))
}

const routes = [
  {
    path: '*',
    component: NotFound,
  },
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    component: Login,
    name: 'Login'
  },
  {
    path: '/test',
    component: Test,
    name: 'Test',
    beforeEnter: verify, 
  },
  {
    path: '/admin',
    component: Admin,
    name: 'Admin',
    children: [
      {
        path: 'roles',
        component: Roles,
        name: 'Roles'

      },
      {
        path: 'users',
        component: User,
        name: 'User'
      },
      {
        path: 'ueb',
        component: Ueb,
        name: 'Ueb'
      },
      {
        path: 'cultivos',
        component: Cultivo,
        name: 'Cultivo'
      },
      {
        path: 'ausencias',
        component: Ausencia,
        name: 'Ausencia'
      },
      {
        path: 'quimicos',
        component: Quimicos,
        name: 'Quimicos'
      },
      {
        path: 'valores',
        component: Valores,
        name: 'Valores'
      }
    ],
    beforeEnter: verify,
  },
]

const router = new VueRouter({routes})

router.beforeEach(( to, from, next ) => {
  const token = localStorage.getItem('token') || null
  window.axios.defaults.headers['Authorization'] = "Bearer " + token;
  next();
})


export default router
