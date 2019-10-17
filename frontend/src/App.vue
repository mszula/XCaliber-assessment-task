<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-row>
          <v-col cols="12" md="8">
            <v-card>
              <v-card-title>Player</v-card-title>
              <v-card-text>
                <v-select :items="players" item-text="fullName" item-value="id" label="Player" @change="selectPlayer"></v-select>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="6" md="4" v-if="selectedPlayer != null">
            <v-card>
              <v-card-title>Balance</v-card-title>
              <v-card-text >
                <v-simple-table>
                  <template v-slot:default>
                    <tbody>
                      <tr>
                        <td>Total balance</td>
                        <td>{{ wallets.totalBalance }}</td>
                      </tr>
                      <tr>
                        <td>Real money balance</td>
                        <td>{{ wallets.realMoneyBalance }} {{ wallets.currency }}</td>
                      </tr>
                      <tr v-for="(bonusWallet, index) in wallets.bonusWallets" :key="index">
                        <td>Bonus</td>
                        <td>{{ bonusWallet.balance }} {{ bonusWallet.currency }}</td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row v-if="selectedPlayer != null">
          <v-col cols="12" md="8">
            <v-card>
              <v-card-title>Simulate deposit</v-card-title>
              <v-card-text>
                <v-text-field label="Amount" v-model="depositAmount"></v-text-field>
                <v-btn color="primary" @click="makeDeposit(depositAmount)">Deposit</v-btn>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row v-if="selectedPlayer != null">
          <v-col cols="12" md="8">
            <v-card>
              <v-card-title>Simulate login</v-card-title>
              <v-card-text>
                <v-btn color="primary" @click="simulateLogin">Login</v-btn>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row v-if="selectedPlayer != null">
          <v-col cols="12" md="8">
            <v-card>
              <v-card-title>I wanna play a game</v-card-title>
              <v-card-text>
                <v-text-field label="Bet amount" v-model="betAmount"></v-text-field>
                <v-btn color="primary" @click="spin(betAmount)">Spin</v-btn>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>

    <v-snackbar :timeout="snackbar.timeout" bottom :color="snackbar.color" v-model="snackbar.show">
      {{ snackbar.text }}
      <v-btn text @click="snackbar.show = false">
        Close
      </v-btn>
    </v-snackbar>
  </v-app>
</template>

<script>
  import { mapGetters } from "vuex";
  import {
    FETCH_PLAYERS,
    SELECT_PLAYER,
    MAKE_DEPOSIT,
    SIMULATE_LOGIN,
    SPIN
  } from "./store/actions.type";

  export default {
    name: 'app',
    data() {
      return {
        depositAmount: null,
        betAmount: null
      }
    },
    computed: {
      ...mapGetters(["snackbar", "players", "wallets", "selectedPlayer"])
    },
    components: {

    },
    methods: {
      fetchPlayers() {
        this.$store.dispatch(FETCH_PLAYERS);
      },
      selectPlayer(id) {
        this.$store.dispatch(SELECT_PLAYER, id);
      },
      makeDeposit(depositAmount) {
        this.$store.dispatch(MAKE_DEPOSIT, depositAmount);
      },
      simulateLogin() {
        this.$store.dispatch(SIMULATE_LOGIN);
      },
      spin(betAmount) {
        this.$store.dispatch(SPIN, betAmount);
      }
    }
  }
</script>

<style>

</style>
