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
        },
        getWargearSelectors: (state) => (fighterId, selectorId) => {
            const fighter = _.find(state.killteam.fighters, { id: fighterId })
            const selector = _.find(fighter.wargearSelectors, {id: selectorId })
            return selector
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
        updateFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
        addFighter(state, obj) {
            let fighter = _.cloneDeep(obj.miniature)
            fighter.miniatureId = fighter.id
            fighter.factionId = obj.factionId
            fighter.finalPoints = fighter.points
            fighter.finalArmament = fighter.armament
            fighter.wargearMasks = []
            delete fighter.id
            fighter.id = UUID()
            fighter.wargearSelectors = []
            _.each(fighter.wargear_options, (wgo) => {
                fighter.wargearSelectors.push({
                    id: UUID(),
                    isSelected: false,
                    replace: wgo.replace,
                    option: ('ALLOF' == wgo.method) ? wgo.options : null,
                    wgo: wgo
                })
            })
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
        },
        selectWargear(state, obj) {
            let fighter = _.find(state.killteam.fighters, (x) => x.id == obj.fighter_id)
            const selection = obj.selection
            const replace = (_.isArray(selection.replace)) ? selection.replace : [selection.replace]
            const option = (_.isArray(selection.option)) ? selection.option : [selection.option]
            // clear previous masks
            fighter.wargearMasks = _.reject(fighter.wargearMasks, { selection_id: selection.selection_id })
            // add to masks
            if (selection.isSelected) {
                fighter.wargearMasks.push({
                    selection_id: selection.selection_id,
                    replace_items: replace,
                    add_items: option,
                })
            }
            let finalArmament = _.clone(fighter.armament)
            _.each(fighter.wargearMasks, (mask) => {
                _.each(mask.replace_items, (item) => {
                    _.remove(finalArmament, x => x == item)
                })
                _.each(mask.add_items, (item) => {
                    finalArmament.push(item)
                })
            })
            fighter.finalArmament = finalArmament
            fighter.finalPoints = fighter.points + _.reduce(fighter.finalArmament, (xs, x) => {
                const item = _.find(state.factions[fighter.factionId].wargear, { id: x })
                return xs + item.points
            }, 0)
        }
    }
})
