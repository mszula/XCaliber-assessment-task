import Vue from "vue";
import Vuex from "vuex";

import snackbar from "./snackbar.module";
import game from "./game.module";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    snackbar,
    game
  }
});
