import store from "../store";
import get from 'lodash/get';

export default function(to, from, next) {
  const role = get(store.getters.user, 'role.name');
  if(role !== 'Usuario UEB') {
    next('/403');
  }
}