import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

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
     isAdmin: state => state.auth.user?.role.name === 'Administrator'
   },
   mutations: {
     login(state, user) {
        state.auth.user = user
     },
     logout(state) {
       state.auth.user = null
     }
   }
});