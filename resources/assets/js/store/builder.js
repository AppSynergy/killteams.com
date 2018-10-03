import Vue from 'vue'
import Vuex from 'vuex'
import factions from './modules/factions.js'
import killteam from './modules/killteam.js'
import killteams from './modules/killteams.js'
import specialisms from './modules/specialisms.js'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        factions, killteams, killteam, specialisms
    }
})
