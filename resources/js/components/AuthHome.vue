<template>
  <div v-if="user != null">
    <navbar :user="user" />
    <b-card class="m-4 md:m-8">
      <b-row>
        <b-col md="4" offset-md="1">
          <b-button
            v-b-modal.create-room-modal
            variant="outline-primary"
            class="md:h-24"
            block
          >Crear nueva partida</b-button>
        </b-col>
        <b-col md="4" offset-md="2">
          <b-button
            v-b-modal.join-room-modal
            variant="outline-secondary"
            class="md:h-24"
            block
          >Unirse a una partida</b-button>
        </b-col>
      </b-row>
      <p class="mt-4 text-2xl font-bold">Historial de partidas</p>
      <div v-if="record == null || record.length == 0 ">
        <p class="text-black">Aún no has jugado ninguna partida</p>
      </div>
      <div v-else class="table-responsive">
        <b-table striped hover :items="calcRecords" :fields="fields">
          <template v-slot:cell(btn)="row">
            <b-button
              size="sm"
              :href="'/juego/'+ row.item.mesa_id+'?user='+row.item.guest_id"
            >Ver detalles</b-button>
          </template>
        </b-table>
      </div>
    </b-card>
    <join-room :user="user" />
    <create-room :user="user" />
  </div>
</template>

<script>
import navbar from "./Layout/Navbar";
import JoinRoom from "./modals/JoinRoom";
import CreateRoom from "./modals/CreateRoom";

export default {
  name: "AuthHome",
  components: {
    navbar,
    JoinRoom,
    CreateRoom
  },
  data() {
    return {
      user: null,
      record: [],
      fields: [
        { key: "mesa", label: "Mesa" },
        { key: "puntos", label: "Puntos" },
        { key: "rondas", label: "Rondas ganadas" },
        { key: "lugar", label: "Lugar" },
        { key: "btn", label: "" },
      ]
    };
  },
  computed: {
    calcRecords() {
      if (this.record.length > 0) {
        return this.record.map(x => {
          return {
            mesa: x.room.name,
            mesa_id: x.room.id,
            puntos: x.points,
            rondas: x.won,
            lugar: x.place,
            guest_id: x.guest_id
          };
        });
      }
    }
  },
  created() {
    User.getRecord().then(data => {
      this.user = data.user;
      this.record = data.record;
    });
  }
};
</script>