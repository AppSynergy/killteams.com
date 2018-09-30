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
        setName(state, name) {
            state.killteam.name = name
        },
        setFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
        addFighter(state, fighter) {
            state.killteam.fighters.push(fighter)
        }
    },
    actions: {
        loadKillteam({commit, dispatch}, {name, fighters}) {
            commit('setName', name)
            _.each(fighters, (fighter) => {
                dispatch('addFighter', fighter)
            })
        },
        addFighter(context, miniature) {
            const fighter = {
                id: UUID(),
                name: 'Bill',
                factionId: miniature.faction_id,
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
