import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// let user = window.localStorage.getItem('role')

const authDefaultState = {
  user: null
}
export default new Vuex.Store({
  state: {
    auth:
    {...authDefaultState}
  },
   getters: {
     user: state => state.auth.user,
     isAdmin: state => state.auth.user?.role.name === 'Administrator',
     isEditor: state => state.auth.user?.role.name === 'Editor',
     isUsuarioUeb: state => state.auth.user?.role.name === 'Usuario UEB'
   },
   mutations: {
     login(state, user) {
        state.auth.user = user

        this.commit('saveRole')
     },
     logout(state) {
       state.auth.user = null
     },
     saveRole(state,) {
       window.localStorage.setItem('role', JSON.stringify(state.auth.user.role.name))
     }
   }
});