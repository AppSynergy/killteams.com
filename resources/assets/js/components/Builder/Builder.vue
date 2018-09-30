<template>
    <div class="vue-builder-builder">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <sidebar
                        :factionId="factionId"
                        :factionKeyword="factionKeyword"
                        :gameMode="gameMode"
                    ></sidebar>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body py-0">
                            <save-buttons></save-buttons>
                            <killteam-form></killteam-form>
                            <div class="fighter-list" dusk="fighters">
                                <draggable v-model="killteam.fighters">
                                    <fighter v-for="fighter, index in killteam.fighters"
                                        :fighter="fighter"
                                        :game-mode="gameMode"
                                        :index="index"
                                        :key="fighter.id"
                                    ></fighter>
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
import KillteamResource from '../../mixins/KillteamResource.js'
import KillteamForm from '../Partial/KillteamForm.vue'
import SaveButtons from '../Partial/SaveButtons.vue'
import Sidebar from '../Partial/Sidebar.vue'
export default {
    components: {
        Draggable, Fighter, KillteamForm, SaveButtons, Sidebar
    },
    mixins: [
        KillteamResource,
    ],
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ]
}
</script>
