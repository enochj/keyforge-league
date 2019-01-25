<template>
  <div>
    <button class="btn btn-primary" @click="addButton()">Add</button>
    <div class="alert alert-success" v-if="saved">
      <strong>Success!</strong> My deck has been added.
    </div>

    <div v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="well well-sm" id="deck-form">
                  <form class="form-horizontal" method="post" >
                    <fieldset>
                      <div class="modal-header">
                        <legend class="text-center">Add a Deck</legend>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="closeModal()">&times;</span>
                        </button>
                      </div>
                    </fieldset>
                  </form>

                      <div class="form-group">
                        <label class="col-md-3 control-label" for="name">Name</label>
                        <div class="col-md-9" :class="{'has-error': errors.name}">
                          <input id="name"
                               v-model="deck.name"
                               type="text"
                               v-focus
                               v-on:keyup.enter="findDeck(deck.name)"
                               placeholder="Deck name"
                               class="form-control">
                          <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0] }}</span>
                        </div>
                      </div>
                      <div v-if="searching" class="form-group col-md-9">
                        Searching...
                      </div>
                      <div v-else>
                        <div class="form-group col-md-9"
                          v-for="(deck, index) in foundDecks"
                          :key="deck.id">
                          <button v-if="index != 5" class ="btn" @click="addDeck(deck)">{{deck.name}}</button>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button :disabled="!deck.name" type="button" class="btn btn-primary" id="find-button" @click="findDeck(deck.name)">Find Deck</button>
                      </div>

                      <!--div class="form-group">
                        <label class="col-md-3 control-label" for="body">Your message</label>
                        <div class="col-md-9" :class="{'has-error': errors.body}">
                              <textarea class="form-control"
                                    id="body"
                                    v-model="signature.body"
                                    placeholder="Please enter your message here..."
                                    rows="5"></textarea>
                          <span v-if="errors.body" class="help-block text-danger">{{ errors.body[0] }}</span>
                        </div>
                      </div-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>1

<script>
  export default {

    data() {
      return {
        saved: false,
        errors: [],
        deck: {
          name: null,
        },
        showModal: false,
        foundDecks: [],
        searching: false,
        exceeded: false
      };
    },

    methods: {
      addButton() {
        this.showModal = true;
        this.saved = false;
      },

      addDeck(deck) {
        axios.post('decks', deck)
          .then(({data}) => {
            this.setSuccessMessage();
            this.$emit('added');
          })
          .catch(({response}) => this.setErrors(response));
      },

      onSubmit() {
        this.findDeck(deck.target.name.value);
        return false;
      },

      setErrors(response) {
        this.errors = response.data.errors;
      },

      setSuccessMessage() {
        this.reset();
        this.saved = true;
        this.showModal = false;
      },

      closeModal() {
        this.showModal = false;
        this.reset();
      },

      reset() {
        this.errors = [];
        this.foundDecks = [];
        this.deck = {name: null};
      },

      createDeck() {
        console.log("you're doing it peter!");
      },

      findDeck($deckName) {
        this.searching = true;
        this.errors = [];
        axios.get('decks/find-decks?name='+$deckName).then(({data}) => {
          this.searching = false;
          this.foundDecks = data.data;
          if (this.foundDecks.length == 6) {
            this.errors = {
              'name' : ['The number of results is more than the number displayed.'],
              'id' : ['The number of results is more than the number displayed.']
            };
          } else if (this.foundDecks.length == 0) {
            this.errors = {
              'name' : ['No results were found.'],
              'id' : ['No results were found.']
            };
          }
        });
      }
    }
  }
</script>