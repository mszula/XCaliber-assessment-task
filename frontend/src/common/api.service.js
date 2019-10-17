import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import {
  FETCH_PLAYERS,
  SHOW_SNACKBAR,
} from "../store/actions.type";
import store from "../store";

const ApiService = {
  init() {
    Vue.use(VueAxios, axios);
    Vue.axios.defaults.baseURL = process.env.VUE_APP_API_URL;
    Vue.axios.defaults.headers.common["Content-Type"] = "application/json";

    this.addInterceptors();

    store.dispatch(FETCH_PLAYERS);
  },

  addInterceptors() {
    Vue.axios.interceptors.response.use(
      response => {
        return response;
      },
      error => {
        store.dispatch(SHOW_SNACKBAR, {
          text: error.response.data.message,
          color: "error",
          autoclose: false
        });

        return Promise.reject(error);
      }
    );
  },

  get(resource, id) {
    let url = resource;
    if (typeof id !== "undefined") {
      url += `/${id}`;
    }
    return Vue.axios.get(url);
  },

  post(resource, id, params) {
    let url = resource;
    if (typeof id !== "undefined") {
      url += `/${id}`;
    }
    return Vue.axios.post(url, params);
  },
};

export default ApiService;
