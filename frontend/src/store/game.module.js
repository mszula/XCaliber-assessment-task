import ApiService from "@/common/api.service";
import { FETCH_PLAYERS, SELECT_PLAYER, FETCH_WALLETS, MAKE_DEPOSIT, SIMULATE_LOGIN, SPIN } from "./actions.type";
import { SET_PLAYERS, SET_SELECTED_PLAYER, SET_WALLETS } from "./mutations.type";

const state = {
    players: [],
    selectedPlayer: null,
    wallets: {},
};

const getters = {
    players: state => state.players,
    selectedPlayer: state => state.selectedPlayer,
    wallets: state => state.wallets,
};

const actions = {
    [FETCH_PLAYERS](context) {
        return ApiService.get("players").then(({ data }) => {
            context.commit(SET_PLAYERS, data);
        });
    },
    [SELECT_PLAYER](context, id) {
        context.commit(SET_SELECTED_PLAYER, id);
        context.dispatch(FETCH_WALLETS);
    },
    [FETCH_WALLETS](context) {
        return ApiService.get("wallets", state.selectedPlayer).then(({ data }) => {
            context.commit(SET_WALLETS, data);
        });
    },
    [MAKE_DEPOSIT](context, amount) {
        return ApiService.post("make-deposit", state.selectedPlayer, {
            amount: parseInt(amount)
        }).then(() => {
            context.dispatch(FETCH_WALLETS);
        });
    },
    [SIMULATE_LOGIN](context) {
        return ApiService.post("simulate-login", state.selectedPlayer).then(() => {
            context.dispatch(FETCH_WALLETS);
        });
    },
    [SPIN](context, amount) {
        return ApiService.post("spin", state.selectedPlayer, {
            amount: parseInt(amount)
        }).then(() => {
            context.dispatch(FETCH_WALLETS);
        });
    }
};

/* eslint no-param-reassign: ["error", { "props": false }] */
const mutations = {
    [SET_PLAYERS](state, data) {
        state.players = data.players || [];
    },
    [SET_SELECTED_PLAYER](state, id) {
        state.selectedPlayer = id;
    },
    [SET_WALLETS](state, data) {
        state.wallets = data;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
