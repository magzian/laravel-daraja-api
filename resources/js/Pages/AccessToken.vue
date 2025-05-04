<template>
    <div class="max-w-4xl mx-auto mt-10 px-4">
        <!-- Obtain Access Token Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Obtain Access Token
            </h2>
            <h4 class="text-gray-600 text-lg mb-4">{{ accessToken }}</h4>
            <button @click="getAccessToken" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Request Access Token
            </button>
        </div>

        <!-- Register URLs Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Register URLs
            </h2>
            <h4 class="text-gray-600 text-lg mb-4">{{ responseDescription }}</h4>
            <button @click="registerUrls" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Register URLs
            </button>
        </div>

        <!-- Optional Form Example -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Simulate Transactions
            </h2>
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-medium mb-2">Amount</label>
                    <input type="amount" id="amount" v-model="amount"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                </div>
                <div class="mb-4">
                    <label for="account" class="block text-gray-700 font-medium mb-2">Account</label>
                    <input type="text" id="account" v-model="account"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                </div>
                <button @click="simulatePayments" type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simulate Payment
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

const accessToken = ref("");
const responseDescription = ref("");
const amount = ref("");
const account = ref("");

const getAccessToken = async () => {
    try {
        const response = await axios.get("/api/access-token");
        accessToken.value = response.data.access_token;
        /* console.log("Access Token:", accessToken.value); */
        Swal.fire("Success", "Access token retrieved.", "success");
    } catch (error) {
        Swal.fire("Error", "Failed to retrieve access token.", "error");
    }
};

const registerUrls = async () => {
    try {
        const response = await axios.get("/api/register-urls");
        /* console.log(response.data.ResponseDescription); */
        responseDescription.value = response.data.ResponseDescription;  
        Swal.fire("Success", "URLs registered successfully.", "success");
    } catch (error) {
        Swal.fire("Error", "Failed to register URLs.", "error");
    }
};

const simulatePayments = async () => {
    try {
        const response = await axios.post("/api/simulate-payment",{
            amount:amount.value,
            account:account.value,
        });
        console.log(response.data);

        Swal.fire("Success", "Payment successful.", "success");
    } catch (error) {
        Swal.fire("Error", "Payment failed.", "error");
    }
}



</script>
