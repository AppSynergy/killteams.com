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
        getKillteam: (state) => {
            return state.killteam
        }
    },
    mutations: {
        setFighters(state, killteam) {
            state.killteam = killteam
        },
        setFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
        addFighter(state, fighter) {
            state.killteam.fighters.push(fighter)
        }
    },
    actions: {
        addFighter(context, {factionId, miniature}) {
            const fighter = {
                id: UUID(),
                name: 'Bill',
                factionId,
                miniatureId: miniature.id,
                miniature,
            }
            context.commit('addFighter', fighter)
        }
    }
}

export default new Vuex.Store({
    modules: {
        factionsModule, killteamModule
    }
})
