import axios from 'axios';
import router from '../router';
import i18n from '../i18n';

const url_api = 'api/v1/';

const getHeaders = () => ({
    Authorization: `Bearer ${localStorage.getItem('token')}`,
    Locale: i18n.global.locale,
});

const handleResponse = (promise, json) => {
    promise
        .then((response) => json(response.data))
        .catch((error) => json(error.response));
};

const axiosRequest = (url, data, json) => {
    const headers = getHeaders();
    handleResponse(
        axios.post(`${url_api}${url}`, data, { headers }),
        json
    );
};

const axiosGetRequest = (url, json, params = null) => {
    const token = localStorage.getItem('token');
    if (!token) {
        router.push({ name: 'login' });
        return;
    }

    const headers = getHeaders();
    handleResponse(
        axios.get(`${url_api}${url}`, { headers, params }),
        json
    );
};

const axiosPutRequest = (url, body, json) => {
    const headers = getHeaders();

    handleResponse(
        axios.put(`${url_api}${url}`, body, { headers }),
        json
    );
};

const axiosDeleteRequest = (url, json) => {
    const headers = getHeaders();
    handleResponse(
        axios.delete(`${url_api}${url}`, { headers }),
        json
    );
};

export { axiosRequest, axiosGetRequest, axiosPutRequest, axiosDeleteRequest, url_api };
