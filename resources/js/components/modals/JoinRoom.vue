<template>
  <b-modal
    id="join-room-modal"
    ref="modal"
    title="Unirse a una partida"
    @show="initModal"
    @hidden="resetModal"
    @ok="JoinRoom"
  >
    <form ref="formjoin" @submit.stop.prevent="JoinRoom">
      <b-form-group label="Tu nombre" label-for="name-input">
        <b-form-input id="name-input" v-model="form.alias" required :disabled="user != null" />
      </b-form-group>
      <b-form-group label="Número de sala" label-for="sala_id">
        <b-form-select v-model="form.room_id" :options="roomsAvailable" />
      </b-form-group>
      <b-form-group label="Contraseña" label-for="pwd">
        <b-form-input id="pwd" v-model="form.password" required type="password" />
      </b-form-group>
    </form>
  </b-modal>
</template>
<script>
export default {
  name: "JoinRoom",
  data() {
    return {
      form: {
        alias: null,
        password: null,
        room_id: null,
        user_id: null
      },
      rooms: []
    };
  },
  props: {
    user: [Object, null]
  },
  computed: {
    roomsAvailable() {
      if (this.rooms.length > 0) {
        return this.rooms.map(room => {
          return {
            value: room.id,
            text: room.name
          };
        });
      }
      return [];
    }
  },
  methods: {
    initModal() {
      if (this.user != null) {
        this.form.alias = this.user.name;
        this.form.user_id = this.user.id;
      }
      Room.getAvailable().then(rooms => {
        this.rooms = rooms;
      });
    },
    resetModal() {
      this.form = {
        alias: null,
        password: null,
        room_id: null
      };
    },
    JoinRoom(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.$nextTick(() => {
        Room.join(this.form);
        this.$bvModal.hide("modal-prevent-closing");
      });
    }
  }
};
</script>