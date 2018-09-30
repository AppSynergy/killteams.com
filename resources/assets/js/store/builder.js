import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

const factionsModule = {
    state: {
        factions: {},
    },
    getters: {
        getFactions: (state) => {
            return state.factions
        }
    },
    mutations: {
        setFactions(state, factions) {
            state.factions = factions
        }
    }
}

const killteamModule = {
    state: {
        killteam: {
            name: 'Kill Team Name',
            fighters: [],
        }
    },
    getters: {
        getFighters: (state) => {
            return state.killteam.fighters
        }
    },
    mutations: {
        setFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
    }
}

export default new Vuex.Store({
    modules: {
        factionsModule, killteamModule
    }
})
