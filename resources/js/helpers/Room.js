class Room {
    create(data) {
        axios
            .post("/api/nuevo_juego", data)
            .then(res => {
                console.log(res.data);
                localStorage.setItem("guest_id", res.data.guest_key);
                localStorage.setItem("game_id", res.data.id);
                document.cookie = "guest_id=" + res.data.guest_key;
                window.location = "/juego/" + res.data.id;
            })
            .catch(error => console.log(error.response.data));
    }
    joinLocal(data) {
        axios.put("/api/unirse_juego", data)
    }
    join(data) {
        axios
            .put("/api/unirse_juego", data)
            .then(res => {
                localStorage.setItem("guest_id", res.data.guest_key);
                localStorage.setItem("game_id", res.data.id);
                document.cookie = "guest_id=" + res.data.guest_key;
                window.location = "/juego/" + res.data.id;
            })
            .catch(error => console.log(error.response.data));
    }
    close(room_id){
        axios
            .delete(`/api/close_table/${room_id}`)
            .then(res => {
                localStorage.removeItem("guest_id");
                localStorage.removeItem("game_id");
                document.cookie = 'guest_id=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                window.location = "/";
            })
            .catch(error => console.log(error.response.data));
    }
    getAvailable() {
        return axios
            .get("/api/rooms_available")
            .then(res => {
                return res.data;
            })
            .catch(error => console.log(error.response.data));
    }
    getData(id) {
        return axios
            .get(`/api/juego/${id}`)
            .then(res => {
                return res.data;
            })
            .catch(error => {
                window.location = "../";
            });
    }
    getRounds() {
        return axios
            .get(`/api/rounds`)
            .then(res => {
                return res.data;
            })
            .catch(error => console.log(error.response.data));
    }
    getWinners(room_id){
        return axios
            .get(`/api/winners/${room_id}`)
            .then(res => {
                return res.data;
            })
            .catch(error => console.log(error.response.data));
    }
    nextRound(data) {
        return axios
            .put(`/api/siguiente_ronda/${data.room}`, data)
            .then(res => {
                return res.data;
            })
            .catch(error => console.log(error.response.data));
    }
}
export default Room = new Room();
