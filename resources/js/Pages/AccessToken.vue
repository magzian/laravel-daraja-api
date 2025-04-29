<template>
  
     <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="card">
                    <div class="card-header">Obtain Access Token</div>
                    <div class="card-body">
                        <h4>{{ accessToken }}</h4>
                        <button @click="getAccessToken" class="btn btn-primary mt-3">Request Access Token</button>
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header">Register URLs</div>
                    <div class="card-body">
                        <button @click="registerUrls" class="btn btn-primary mt-3">Register URLs</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</template>

<script setup>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const accessToken = ref('');

const getAccessToken = async () => {
    try {
        const response = await axios.get('/api/access-token');
        accessToken.value = response.data.access_token;
        Swal.fire('Success', 'Access token retrieved.', 'success');
    } catch (error) {
        Swal.fire('Error', 'Failed to retrieve access token.', 'error');
    }
};

const registerUrls = async () => {
    try {
        const response = await axios.post('/api/register-urls');
        Swal.fire('Success', 'URLs registered successfully.', 'success');
    } catch (error) {
        Swal.fire('Error', 'Failed to register URLs.', 'error');
    }
};
</script>



