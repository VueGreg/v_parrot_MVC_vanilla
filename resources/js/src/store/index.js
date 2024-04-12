import { createStore } from 'vuex';

export default createStore({
  state() {
    return {
      layoutData: null,
      isConnect: false,
      _csrf: null,
    };
  },
  mutations: {
    setLayoutData(state, data) {
      state.layoutData = data;
      localStorage.setItem('layoutData', JSON.stringify(data));
    },
    setIsConnect(state, isConnected) {
      state.isConnect = isConnected;
      localStorage.setItem('isConnect', isConnected);
    },
    setCsrf(state, crossSite) {
      state._csrf = crossSite;
      localStorage.setItem('_csrf', crossSite);
    }
  },
  actions: {
    saveLayoutData({ commit }, data) {
      commit('setLayoutData', data);
    },
    updateIsConnect({ commit }, isConnected) {
      commit('setIsConnect', isConnected);
    },
    updateCsrf({ commit }, crossSite) {
      commit('setCsrf', crossSite);
    }
  },
  getters: {
    layoutData(state) {
      return state.layoutData || JSON.parse(localStorage.getItem('layoutData'));
    },
    isConnect(state) {
      const storedValue = localStorage.getItem('isConnect');
      return storedValue ? JSON.parse(storedValue) : false;
    },
    _csrf(state) {
      const storedValue = localStorage.getItem('_csrf');
      try {
        return storedValue ? storedValue : null;
      } catch (error) {
        console.error("Erreur lors de l'analyse du jeton CSRF:", error);
        return null;
      }
    }
  }
});