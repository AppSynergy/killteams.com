import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        factions: [],
        faction: []
    },
    getters: {
        getFactions(state) {
            return state.factions
        },
        getFaction(state) {
            return state.faction
        }
    },
    mutations: {
        setFactions(state, factions) {
            state.factions = factions
        },
        setFaction(state, faction) {
            state.faction = faction
        }
    }
})
