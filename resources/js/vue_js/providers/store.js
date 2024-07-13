//  PATH = resources/js/vue_js/providers/store.js
import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      currentStep: 1,
      formData: {
        step1: {},
        step2: {},
        step3: {},
      },
    };
  },
  mutations: {
    setCurrentStep(state, step) {
      state.currentStep = step;
    },
    setFormData(state, { step, data }) {
      state.formData[`step${step}`] = data;
    },
  },
  actions: {
    nextStep({ commit, state }) {
      commit('setCurrentStep', state.currentStep + 1);
    },
    prevStep({ commit, state }) {
      commit('setCurrentStep', state.currentStep - 1);
    },
    saveFormData({ commit }, { step, data }) {
      commit('setFormData', { step, data });
    },
  },
});

export default store;
