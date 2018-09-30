<template>
    <div class="vue-builder-builder">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <div class="card mb-4">
                        <sidebar
                            :factionId="factionId"
                            :gameMode="gameMode"
                        ></sidebar>
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="card mb-4">

                        <div class="card-body py-0">
                            <div class="fighter-list" dusk="fighters">
                                <draggable v-model="fighters">
                                    <fighter v-for="fighter, index in fighters"
                                        :key="fighter.id"
                                        :factions="factions"
                                        :fighter="fighter"
                                        :fighters-wargear="fightersWargear"
                                        :index="index"
                                        :specialisms="specialisms"
                                        :game-mode="gameMode"
                                    ></fighter>
                                    <pre>{{ fighters }}</pre>
                                </draggable>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Draggable from 'vuedraggable'
import Fighter from './Fighter.vue'
import Sidebar from './Partial/Sidebar.vue'
export default {
    components: {
        Draggable, Fighter, Sidebar
    },
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ],
    data() {
        return {

        }
    },
    computed: {
        fighters: {
            get() {
                return this.$store.getters.getFighters
            },
            set(value) {
                this.$store.commit('setFighters', value)
            }
        },
    },
    methods: {

    }
}
</script>
