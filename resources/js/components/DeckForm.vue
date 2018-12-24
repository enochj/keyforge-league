<template>
  <div>
    <button class="btn" @click="showModal=true">Add</button>
    <div class="alert alert-success" v-if="saved">
      <strong>Success!</strong> Your deck has been added successfully.
    </div>

    <div v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="well well-sm" id="deck-form">
                  <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                    <fieldset>
                      <div class="modal-header">
                        <legend class="text-center">Add a Deck</legend>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="showModal = false">&times;</span>
                        </button>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label" for="name">Name</label>
                        <div class="col-md-9" :class="{'has-error': errors.name}">
                          <input id="name"
                               v-model="deck.name"
                               type="text"
                               placeholder="Deck name"
                               class="form-control">
                          <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0] }}</span>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
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
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
  export default {

    data() {
      return {
        errors: [],
        saved: false,
        deck: {
          name: null,
        },
        showModal: false
      };
    },

    methods: {
      onSubmit() {
        this.saved = false;

        axios.post('api/decks', this.deck)
          .then(({data}) => this.setSuccessMessage())
          .catch(({response}) => this.setErrors(response));
      },

      setErrors(response) {
        this.errors = response.data.errors;
      },

      setSuccessMessage() {
        this.reset();
        this.saved = true;
      },

      reset() {
        this.errors = [];
        this.deck = {name: null};
      },

      createDeck() {
        console.log("you're doing it peter!");
      },

      findDeck($deckName) {
        console.log($deckName);
        axios.get('decks/find-decks?name='+$deckName).then(({data}) => {
          console.log(data);
        });
      }
    }
  }
</script>