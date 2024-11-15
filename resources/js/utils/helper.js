import axios from 'axios'
import router from '../router'
import i18n from '../i18n'

const url_api = 'http://127.0.0.1:8000/api/v1/'
let token = localStorage.getItem('token')

const headers = {
    Authorization: `Bearer ${token}`,
    Locale: i18n.global.locale
}

let axiosRequest = function (url, data, json) {
    let token = localStorage.getItem('token')
    const headers = {
        Authorization: `Bearer ${token}`,
        Locale: i18n.global.locale
    }
    let config = {
        headers: headers
    }
    url = `${url_api}${url}`
    axios
        .post(url, data, config)
        .then((response) => {
            return json(response.data)
        })
        .catch((error) => {
            return json(error.response)
        })
}

let axiosGetRequest = function (url, json, params = null) {
    if (!token) {
        router.push({ name: 'login' })
        return
    }
    url = `${url_api}${url}`
    axios
        .get(url, {
            headers: headers,
            params
        })
        .then((response) => {
            return json(response.data)
        })
        .catch((error) => {
            return json(error.response)
        })
}

let axiosPutRequest = function (url, body, json) {
    url = `${url_api}${url}`
    axios
        .put(url, body, { headers: headers })
        .then((response) => {
            return json(response.data)
        })
        .catch((error) => {
            return json(error.response.data)
        })
}

let axiosDeleteRequest = function (url, json) {
    url = `${url_api}${url}`
    axios
        .delete(url, { headers: headers })
        .then((response) => {
            return json(response.data)
        })
}

export { axiosRequest, axiosGetRequest, axiosPutRequest, axiosDeleteRequest, url_api }
