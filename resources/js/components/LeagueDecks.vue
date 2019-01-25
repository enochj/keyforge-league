<template>
    <div>
        <div class="alert alert-warning" v-if="alert.length > 0">
            {{alert}}
        </div>
        <div class="panel panel-default" v-if="decks" v-for="deck in decks">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    {{deck.name }} | Wins: {{deck.membership.wins}} Losses: {{deck.membership.losses}} | Games | <a href="javascript:void(0);" id="remove" @click="removeDeck(deck.id)">Remove</a>
                </div>
            </div>
            <div class="panel-footer">
            </div>
        </div>
        <!--paginate
                :page-count="pageCount"
                :click-handler="fetch"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'">
        </paginate-->
        <league-deck-form v-on:added="addDeck" :my_decks="my_decks" :league="league"></league-deck-form>
    </div>
</template>

<script>
    export default {
        props: ['my_decks', 'league'],

        data() {
            return {
                alert: 'Loading',
                pageCount: 1,
                endpoint: 'leagues',
                decks: {}
            };
        },

        created() {
            this.fetch();
        },


        methods: {
            fetch(page = 1) {
                axios.get(this.league.id+'/decks?page='+ page)
                    .then(({data}) => {
                        this.decks = data;
                        //this.pageCount = data.meta.last_page;
                        this.alert = '';
                    });
            },

            //Instead of getting decks from props we need to make an axios call so we can add to it w/o changing props
            addDeck(value) {
                let deck = JSON.parse(value);
                deck.membership = {};
                deck.membership.wins = 0;
                deck.membership.losses = 0;
                this.decks.push(deck);
            },

            removeDeck(id) {
                if(confirm(
                    'Are you sure you want to remove this deck?'
                )) {
                    axios.delete('decks', {data: {'id': this.league.id, 'deck_id': id}})
                        .then(({data}) => {
                            if (data) {
                                this.saved = false;
                                this.decks = _.remove(this.decks, function (deck) {
                                    return deck.id !== id;
                                });
                            }
                        });
                }
            }
        }
    }
</script>