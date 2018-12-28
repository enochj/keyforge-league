<template>
    <div>
        <div class="alert alert-warning" v-if="alert.length > 0">
            {{alert}}
        </div>
        <div class="panel panel-default" v-for="deck in decks">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    {{deck.name }} | <a href="javascript:void(0);" id="remove" @click="removeDeck(deck.id)">Remove</a>
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
        <deck-form v-on:added="added" ></deck-form>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                alert: 'Loading',
                decks: [],
                pageCount: 1,
                endpoint: 'decks',
            };
        },

        watch: {
            decks: function (val, oldval) {
                if (val.length == 0) {
                    this.alert = "I have no decks. The 'Add' button will begin the process";
                } else {
                    this.alert = '';
                }
            },
        },

        created() {
            this.fetch();
        },


        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint +'?page='+ page)
                    .then(({data}) => {
                        this.decks = data;
                        //this.pageCount = data.meta.last_page;
                    });
            },

            added() {
                this.saved = true;
                this.fetch();
            },

            report(id) {
                if(confirm('Are you sure you want to remove this deck?')) {
                    axios.put('decks/'+id+'/remove')
                    .then(response => this.removeDeck(id));
                }
            },

            removeDeck(id) {
                axios.delete(this.endpoint+'/'+id)
                    .then(({data}) => {
                        if (data) {
                            this.saved = false;
                            this.decks = _.remove(this.decks, function (deck) {
                                return deck.id !== id;
                            });
                        }
                    });
            },

            createDeck() {
                console.log("you're doing it peter");
            }
        }
    }
</script>