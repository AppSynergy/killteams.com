export default {
    state: {
        killteams: [],
        killteamsLoaded: false,
    },
    getters: {
        getKillteams: (state) => {
            return state.killteams
        },
        getKillteamsLoaded: (state) => {
            return state.killteamsLoaded
        }
    },
    mutations: {
        setKillteams(state, killteams) {
            state.killteams = killteams
        },
        setKillteamsLoaded(state, boolean) {
            state.killteamsLoaded = boolean
        }
    }
}
