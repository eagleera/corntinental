<template>
  <b-modal
    id="create-room-modal"
    ref="modal"
    title="Crear nueva mesa"
    @show="initModal"
    @hidden="resetModal"
    @ok="createRoom"
  >
    <form ref="formcreate" @submit.stop.prevent="createRoom">
      <b-form-group label="Nombre de la mesa" label-for="name-input">
        <b-form-input id="name-input" v-model="form.room_name" required />
      </b-form-group>
      <b-form-group label="Tu nombre" label-for="name-input">
        <b-form-input id="name-input" v-model="form.alias" required :disabled="user != null" />
      </b-form-group>
    </form>
  </b-modal>
</template>
<script>
export default {
  name: "CreateRoom",
  props: {
    user: [Object, null]
  },
  data() {
    return {
      form: {
        room_name: null,
        alias: null,
        user_id: null
      }
    };
  },
  methods: {
    initModal() {
      if (this.user != null) {
        this.form.alias = this.user.name;
        this.form.user_id = this.user.id;
      }
    },
    resetModal() {
      this.form = {
        room_name: null,
        alias: null,
        user_id: null
      };
    },
    createRoom(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.$nextTick(() => {
        Room.create(this.form);
        this.$bvModal.hide("modal-prevent-closing");
      });
    }
  }
};
</script>