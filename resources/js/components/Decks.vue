<template>
    <div>
        <div class="alert alert-warning" v-if="decks !== null">
            I have no decks. The 'Add' button will begin the process.
        </div>
        <div class="panel panel-default" v-for="deck in decks">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-user" id="start"></span>
                <label id="started">By</label> {{ deck.name }}
            </div>
            <div class="panel-body">
                <div class="col-md-2">
                    <div class="thumbnail">
                        <img :src="deck.avatar" :alt="deck.name">
                    </div>
                </div>
                <p>{{ deck.body }}</p>
            </div>
            <div class="panel-footer">
                <span class="glyphicon glyphicon-calendar" id="visit"></span> {{ deck.updated_at }} |
                <span class="glyphicon glyphicon-flag" id="comment"></span>
                <a href="#" id="remove" @click="remove(deck.id)">Remove</a>
            </div>
        </div>
        <!--paginate
                :page-count="pageCount"
                :click-handler="fetch"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'">
        </paginate-->
    </div>
</template>

<script>
    export default {

        data() {
            return {
                decks: [],
                pageCount: 1,
                endpoint: 'decks?page='
            };
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint + page)
                    .then(({data}) => {
                        this.decks = data.data;
                        //this.pageCount = data.meta.last_page;
                    });
            },

            report(id) {
                if(confirm('Are you sure you want to remove this deck?')) {
                    axios.put('decks/'+id+'/remove')
                    .then(response => this.removeDeck(id));
                }
            },

            removeDeck(id) {
                this.decks = _.remove(this.decks, function (deck) {
                    return deck.id !== id;
                });
            },

            createDeck() {
                console.log("you're doing it peter");
            }
        }
    }
</script>