<template>
  <div v-if="user != null">
    <navbar :user="user" />
    <b-card class="m-4 md:m-8">
      <b-row>
        <b-col md="4" offset-md="1">
          <b-button variant="outline-primary" class="md:h-24" block>Crear nueva partida</b-button>
        </b-col>
        <b-col md="4" offset-md="2">
          <b-button v-b-modal.join-room-modal variant="outline-secondary" class="md:h-24" block>Unirse a una partida</b-button>
        </b-col>
      </b-row>
      <p class="mt-4 text-2xl font-bold">Historial de partidas</p>
      <div v-if="record == null || record.length == 0 ">
        <p class="text-black">Aún no has jugado ninguna partida</p>
      </div>
    </b-card>
    <join-room :user="user" />
  </div>
</template>

<script>
import navbar from "./Layout/Navbar";
import JoinRoom from "./modals/JoinRoom";

export default {
  name: "AuthHome",
  components: {
    navbar,
    JoinRoom
  },
  data(){
    return {
      user: null,
      record: []
    }
  },
  created(){
    User.getRecord().then(data => {
      this.user = data.user;
      this.record = data.record;
    })
  }
};
</script>