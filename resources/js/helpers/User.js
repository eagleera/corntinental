class User {
    login(data) {
        return axios
            .post("/api/auth/login", data)
            .then(res => {
                if (res.data) {
                    console.log(res.data.access_token);
                    localStorage.setItem("access_token", res.data.access_token);
                    const JWTtoken = `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`;

                    window.axios.defaults.headers.common[
                        "Authorization"
                    ] = JWTtoken;
                    return true;
                }
            })
            .catch(error => error.response.data);
    }
    logout() {
        localStorage.removeItem("access_token");
        location.reload();
    }
    register(data) {
        return axios
            .post("/api/auth/signup", data)
            .then(res => {
                console.log(res.data);
                localStorage.setItem("access_token", res.data.access_token);
                const JWTtoken = `Bearer ${localStorage.getItem(
                    "access_token"
                )}`;
                window.axios.defaults.headers.common[
                    "Authorization"
                ] = JWTtoken;
                location.reload();
            })
            .catch(error => {
                return error.response.data.errors;
            });
    }
    getRecord() {
        return axios.get("/api/record").then(res => {
            return res.data;
        });
        // .catch(error => {
        //     localStorage.removeItem("access_token");
        //     location.reload();
        // });
    }
    loggedIn() {
        if (localStorage.getItem("access_token")) {
            const payload = JSON.parse(
                atob(localStorage.getItem("access_token").split(".")[1])
            );
            if (payload) {
                return payload.iss == "https://prograweb.dev/api/auth/login" ||
                    "https://prograweb.dev/api/auth/signup"
                    ? true
                    : false;
            }
            return false;
        }
        return false;
    }
}
export default User = new User();
