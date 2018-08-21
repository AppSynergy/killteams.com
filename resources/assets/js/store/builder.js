import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        factions: {},
        killteam: {
            name: null,
            faction_id: null,
            fighters: [],
        }
    },
    getters: {
        getFactions: (state) => {
            return state.factions
        },
        getFaction: (state) => (factionId) => {
            return state.factions[factionId]
        },
        getKillteam: (state) => {
            return state.killteam
        },
        getFighters: (state) => {
            return state.killteam.fighters
        }
    },
    mutations: {
        clearKillteam(state) {
            state.factions = {}
            state.killteam = {
                name: null,
                faction_id: null,
                fighters: []
            }
        },
        setFactions(state, factions) {
            state.factions = _.cloneDeep(factions)
        },
        setFaction(state, faction) {
            state.factions[faction.id] = _.cloneDeep(faction)
            state.killteam.faction_id = faction.id
        },
        addFighter(state, obj) {
            let fighter = _.cloneDeep(obj.miniature)
            fighter.miniatureId = fighter.id
            fighter.miniatureName = fighter.name
            fighter.factionId = obj.factionId
            fighter.finalPoints = fighter.points
            fighter.finalArmament = fighter.armament
            delete fighter.id
            fighter.id = UUID()
            state.killteam.fighters.push(fighter)
        },
        removeFighter(state, fighter_id) {
            state.killteam.fighters = _.reject(state.killteam.fighters, function(x) {
                return x.id == fighter_id
            })
        },
        setFighterArmament(state, obj) {
            let fighter = _.find(state.killteam.fighters, (x) => x.id == obj.fighter_id)
            const faction = state.factions[fighter.factionId]
            fighter.finalArmament = obj.armament
            fighter.finalPoints = fighter.points + _.reduce(fighter.finalArmament, (xs, x) => {
                const item = _.find(faction.wargear, { id: x })
                return xs + item.points
            }, 0)
        }
    }
})
