import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    getters: {
      Admin: (state) => {
        return state.user ? state.user.Admin : false;
      }
    }
});