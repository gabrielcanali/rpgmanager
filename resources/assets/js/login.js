import Swal from "sweetalert2";

const form = document.getElementById('loginForm')
const url = form.getAttribute('action')

function login(authUrl, data) {
    fetch(authUrl, {
        method: 'POST',
        body: data
    }).then(response => {
        return response.json().then(json => {
            if(response.ok) {
                Swal.fire({
                    title: "Login efetuado",
                    html: json.message,
                    icon: "success",
                    showConfirmButton: true,
                    willClose: () => {
                        location.href = json.redirect
                    } 
                })
            } else {
                setLoading(false)
                Swal.fire(
                    "Não foi possível efetuar login",
                    json.message || "Algo deu errado",
                    "warning",
                )
            }
        });
    }).catch(error => {
        console.log(error)
        setLoading(false)
        Swal.fire(
            "Erro",
            JSON.stringify(error.message),
            "error",
        )
    })
}

function setLoading(loading = true) {
    if (loading) {
        // form.querySelector('button').getAttribute('disabled', true)
    } else {
        // form.querySelector('button').removeAttribute('disabled')
    }
}

form.addEventListener('submit', async function(event) {
    event.preventDefault()
    
    let formData = new FormData(form)

    setLoading()
    login(url, formData)
})
