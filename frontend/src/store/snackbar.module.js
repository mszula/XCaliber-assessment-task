import { SHOW_SNACKBAR } from "./actions.type";
import { SET_SNACKBAR } from "./mutations.type";

const state = {
  snackbar: {
    show: false,
    text: "",
    color: "",
    timeout: 3000
  }
};

const getters = {
  snackbar: state => state.snackbar
};

const actions = {
  [SHOW_SNACKBAR]({ commit }, snackbar) {
    commit(SET_SNACKBAR, snackbar);
  }
};

/* eslint no-param-reassign: ["error", { "props": false }] */
const mutations = {
  [SET_SNACKBAR](state, data) {
    state.snackbar.text = data.text;
    state.snackbar.color = data.color;
    state.snackbar.show = true;

    if ("autoclose" in data) {
      state.snackbar.timeout = data.autoclose ? 3000 : 0;
    } else {
      state.snackbar.timeout = 3000;
    }
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
