import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        factions: [],
        faction: [],
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
        getFaction: (state) => {
            return state.faction
        },
        getKillteam: (state) => {
            return state.killteam
        },
        getFighters: (state) => {
            return state.killteam.fighters
        },
        getFighterPoints: (state) => (fighter) => {
            const armament_points = _.reduce(fighter.armament, (xs, x) => {
                return xs // @TODO + this.getWargearPoints(x)
            }, 0)
            return fighter.points + armament_points
        },
        getTotalPoints: (state, getters) => {
            return _.sum(_.map(state.killteam.fighters, (fighter) => {
                return getters.getFighterPoints(fighter)
            }))
        }
    },
    mutations: {
        clearKillteam(state) {
            state.factions = []
            state.faction = []
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
            state.faction = _.cloneDeep(faction)
            state.killteam.faction_id = faction.id
        },
        addFighter(state, data) {
            let fighter = _.cloneDeep(data)
            fighter.miniature_id = fighter.id
            fighter.miniature_name = fighter.name
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
            fighter.armament = obj.armament
        }
    }
})
