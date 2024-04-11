import { createStore } from 'vuex';

export default createStore({
  state() {
    return {
      layoutData: null,
      isConnect: false
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
    }
  },
  actions: {
    saveLayoutData({ commit }, data) {
      commit('setLayoutData', data);
    },
    updateIsConnect({ commit }, isConnected) {
      commit('setIsConnect', isConnected);
    }
  },
  getters: {
    layoutData(state) {
      return state.layoutData || JSON.parse(localStorage.getItem('layoutData'));
    },
    isConnect(state) {
      const storedValue = localStorage.getItem('isConnect');
      return storedValue ? JSON.parse(storedValue) : false;
    }
  }
});