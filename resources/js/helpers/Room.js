class Room {
    create(alias) {
        axios.post('/api/nuevo_juego', {alias:alias})
            .then(res => {
                console.log(res.data)
                localStorage.setItem('guest_id', res.data.guest_key)
                window.location = '/juego/' + res.data.id;
            })
            .catch(error => console.log(error.response.data))
    }
    join(data){
        axios.put('/api/unirse_juego', data)
            .then(res => {
                console.log(res.data)
                localStorage.setItem('guest_id', res.data.guest_key)
                window.location = '/juego/' + res.data.id;
            })
            .catch(error => console.log(error.response.data))
    }
    getAvailable(){
        return axios.get('/api/rooms_available')
            .then(res => {
                return res.data;
            })
            .catch(error => console.log(error.response.data))
    }
}
export default Room = new Room();