class User {
    login(data) {
        axios.post('/api/auth/login', data)
            .then(res => {
                localStorage.setItem('access_token', res.data.access_token);
                location.reload();
            })
            .catch(error => console.log(error.response.data))
    }
    logout(){
        localStorage.removeItem('access_token');
        location.reload();
    }
    register(data) {
        axios.post('/api/auth/signup', data)
            .then(res => {
                console.log(res.data)
                localStorage.setItem('access_token', res.data.access_token);
                location.reload();
            })
            .catch(error => console.log(error.response.data))
    }
    getRecord(){
        return axios.get('/api/record')
            .then(res => {
                return res.data;
            })
            .catch(error => {
                localStorage.removeItem('access_token');
                location.reload();
            })
    }
    loggedIn(){
        if(localStorage.getItem('access_token')){
            const payload = JSON.parse(atob(localStorage.getItem('access_token').split(".")[1]));
            if(payload){
                return payload.iss == 'https://prograweb.dev/api/auth/login' || 'https://prograweb.dev/api/auth/signup' ? true : false
            }
            return false
        }
        return false;
    }
}
export default User = new User();