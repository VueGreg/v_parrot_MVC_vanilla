import { createStore } from 'vuex';

export default createStore({
  state() {
    return {
      layoutData: null
    };
  },
  mutations: {
    setLayoutData(state, data) {
      state.layoutData = data;
      localStorage.setItem('layoutData', JSON.stringify(data));
    }
  },
  actions: {
    saveLayoutData({ commit }, data) {
      commit('setLayoutData', data);
    }
  },
  getters: {
    layoutData(state) {
      return state.layoutData || JSON.parse(localStorage.getItem('layoutData'));
    }
  }
});