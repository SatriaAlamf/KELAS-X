import axios from "axios";

const token = "3bgsUUIsynVXWmT9GQwbKLakFT10QQJe2X3vNRYj";

const instance = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    api_token: token,
  },
});

export default instance;
